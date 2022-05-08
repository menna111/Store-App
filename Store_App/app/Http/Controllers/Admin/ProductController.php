<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
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
        return view('admin.products.add',compact('categories'));
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
        return view('admin.products.show',compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product=Product::findOrFail($id);
        $categories=Category::all();
        return view('admin.products.edit',compact('id','product','categories'));
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

        try {
            DB::beginTransaction();

            if ($request->has('image') && $request->file('image')->isValid() ){
                $data['image']=$this->uploadImage($request->file('image'),'uploaded/products',50);
            }



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
}
