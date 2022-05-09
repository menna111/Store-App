<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Tag;
use App\Traits\ImageUpload;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    use ImageUpload,ResponseTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $request=request();    //اللي جايلي من السيرش
        $filters=$request->query();

        $products=Product::query()->with('category','user');  // بترجعلي الكويري نفسه هعمل عليه عمليات

        if ($request->query('name')){
            $products->where('name','LIKE','%' .$request->query('name'). '%' );
        }

        if ($request->query('price_min')){
            $products->where('price','>=',$request->query('price_min'));
        }

        if ($request->query('price_max')){
            $products->where('price','<=',$request->query('price_max'));
        }
        if ($request->query('category_id')){
            $products->where('category_id',$request->query('category_id'));
        }
        $categories=Category::all();
        return view('admin.products.index',['categories' => $categories,
            'products' =>$products->paginate(10),'filters' =>$filters
        ]) ;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories=Category::all();
        $tags=Tag::all();

        return view('admin.products.add',compact('categories','tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //validation
        $request->validate([
            'name' =>'required|max:255',
            'category_id' =>'required|exists:categories,id',
            'price' =>'required|numeric|min:0',
            'sale_price' =>'nullable|numeric|min:0',
            'quantity' =>'int|min:0',
            'description'=>'max:255|required',
            'image' =>'mimes:jpeg,jpg,png,bmp|max:1024000',

        ]);
        $data=$request->except('image');

        try {
            DB::beginTransaction();

            if ($request->has('image') && $request->file('image')->isValid() ){
                $data['image']=$this->uploadImage($request->file('image'),'uploaded/products',50);
            }

            $product=Product::create($data);
            $tags=$request->post('tag');

            $this->saveTags($product,$request);     //pass to function that check and create tags

//            $product->tags()->sync($tags);

            DB::commit();

        }catch (\Exception $exception){
            DB::rollBack();
            dd($exception->getMessage());
            return $this->returnError('error','some thing wrong',400);

        }
        return $this->returnSuccess('added successfully',200);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product=Product::findOrFail($id);
        $tags=Tag::where('product_id',$product->id);
        return view('admin.products.show',compact('product','tags'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $categories=Category::all();
        $tags=Tag::all();

        $product=Product::findOrFail($id);
//        $product_tags=$product->tags->pluck('id')->toArray();      //بيرجع عمود واحد م الجدولpluck
        $product_tags=implode(',', $product->tags->pluck('name')->toArray()) ;
        return view('admin.products.edit',compact('id','product','categories','tags','product_tags'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $product=Product::findOrFail($id);
        //validation
        $request->validate([
            'name' =>'required|max:255',
            'category_id' =>'required|exists:categories,id',
            'price' =>'required|numeric|min:0',
            'sale_price' =>'nullable|numeric|min:0',
            'quantity' =>'int|min:0',
            'description'=>'max:255|required',
            'image' =>'mimes:jpeg,jpg,png,bmp|max:1024000|nullable',

        ]);

        $data=$request->except('image');


        $tags=$request->post('tag');      //[] second parameter is a default value

        try {
            DB::beginTransaction();


            $this->saveTags($product,$request);     //pass to function that check and create tags


//            $product->tags()->sync($tags);               //delete id and insert the newest in one command
//            DB::table('product_tag')->where('product_id',$product->id)->delete();  //delete old and insert the new
//            foreach ($tags as $tag_id){
//            DB::table('product_tag')->insert([
//                'product_id' =>$product->id,
//                'tag_id' =>$tag_id
//
//            ]);
//            }


            //error in image ???????????
//            if ($request->has('image') && $request->file('image')->isValid() ){
//                $data['image']=$this->uploadImage($request->file('image'),'uploaded/products',50);
//            }



            $product->update($data);

            DB::commit();

        }catch (\Exception $exception){
            DB::rollBack();
            dd($exception->getMessage());
            return redirect()->back()->with('error','some thing wrong',400);

        }
        return redirect()->back()->with('success','updated successfully',201);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product=Product::findOrFail($id);
        if (is_null($product)){
            return  $this->returnError('not found',404);
        }
        $product->delete();
        if($product->image){
            Storage::disk('public')->delete($product->image);
        }
        return back()->with('success','deleted');
    }



    public function saveTags(Product $product,Request $request){         //insert tags by input user write them

        $tags=$request->post('tag');

        $tags=explode(',', $tags ) ;

        $tags_ids=[];                                                                  //to intialize array



        foreach ($tags as $name){                                        //  loop to find tag is exist in tags table

            $name=strtolower(trim($name));
            $tag=Tag::where('name',$name)->first();

            if (! $tag){                                                  //if tag not exist create it
              $tag=  Tag::create([
                    'name' =>$name
                ]);
            }
            $tags_ids[]=$tag->id;                          //to insert tags in the relation we put ids in array

        }
        $product->tags()->sync($tags_ids);                          // insert the ids in relation table

    }
}
