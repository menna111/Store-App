<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use App\Models\User;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UsersController extends Controller
{
    use ResponseTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users=User::with('profile')->paginate(4);
        return view('admin.users.index',compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' =>'required|max:50|min:3|string',
            'email' =>'unique:users,email|required',
            'password' =>'required|confirmed|max:50|min:8',
            'birthday' =>'required|date',
            'gender' =>'required|in:male,female',
            'city' =>'nullable',
            'country' =>'nullable',
            'address' =>'nullable',

        ]);
        DB::beginTransaction();
       $user= User::create([
            'name'=> $request->post('name'),
            'email'=> $request->post('email'),
            'passwword'=> Hash::make($request->post('name')),
        ]);
        Profile::create([
            'user_id' =>$user->id,
            'birthday' =>$request->post('birthday'),
            'gender' =>$request->post('gender'),
            'city' =>$request->post('city'),
            'country' =>$request->post('country'),
            'address' =>$request->post('address'),
        ]);
        DB::commit();


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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
