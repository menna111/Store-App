<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\categories\StoreRequest;
use App\Http\Requests\categories\UpdateRequest;
use App\Models\Category;
use App\Http\Controllers\Controller;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    use ResponseTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories=Category::all();
        return view('Admin.categories.index',compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories=Category::with('parent')->withCount('products as products')->paginate();

        return view('Admin.categories.add',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        $validated = $request->validated();
        Category::create($request->all());
        return $this->returnSuccess('added successfully',200);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category=Category::findOrFail($id);
        $categories=Category::where('id','!=',$id)
        ->where(function ($query) use ($id){
        $query->where('parent_id','!=',$id)->orWhereNull('parent_id');
        })
        ;

        return view('Admin.categories.edit',compact('categories','category','id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //validation
        $validator=Validator::make($request->all(),[
            'name' =>['required',"unique:categories,name,$id"],
            'parent_id'=>['nullable','exists:categories,id'],
            'description'=>'string|max:255|min:3',
        ]);
        if ($validator->fails()){
        return $this->returnError($validator->errors()->all(),400);
    }

        $category=Category::whereId($id)->first();

        try{

        $category->update($request->all());
//         return  $this->returnSuccess('updated successfully',201);
            return back()->with('success','updated successfully');

        }catch (\Exception $exception){
            return $exception->getMessage();
            return back()->with('error','some thing wrong');
//            return $this->returnError('some thing wrong',500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category=Category::findOrFail($id);
        if (is_null($category)){
            return  $this->returnError('not found',404);
        }
        $category->delete();
            return back()->with('success','deleted');
    }
}
