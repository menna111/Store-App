@extends('Admin.layouts.Admin-dashboard')
@section('title','users')
@section('main_title','users')
@section('page','users')
@section('content')
<div class="row">
{{--    <h1>users</h1>--}}

    @if(session()->has('success'))
        <div class="alert alert-success">
            {{session('success')}}
        </div>
    @endif
            <!-- Button trigger modal -->
       <div>
           <a href="{{url('/users/create')}}" class="btn btn-primary m-3 " data-bs-toggle="modal" data-bs-target="#user" id="adduser">
               Add user
           </a>
       </div>



    <table class="table">
        <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Email</th>
            <th>Birthday</th>
            <th>Gender</th>
            <th>city</th>
            <th>Actions</th>
        </tr>
        </thead>

        <tbody>
        @forelse($users as $user)
        <tr>
            <td>{{$loop->iteration}}</td>
            <td>{{$user->name}}</td>
            <td>{{$user->email}}</td>
            <td>{{$user->profile->birthday}} </td>
            <td>{{$user->profile->gender}} </td>
            <td>{{$user->profile->city}} </td>

            <td>
                <a href="" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#user"  onclick="edituser({{$user->id}})">
                    Edit </a>
                <a href="{{route('user.delete',$user->id)}}" class="btn btn-danger">Delete</a>

            </td>
        </tr>
        @empty
            <tr>
                <td colspan="3">
                    <p>no user</p>
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>




        <!-- Modal -->
        <div class="modal fade" id="user" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="content">

                    </div>
                </div>
            </div>
        </div>

@endsection
@section('script')
    <script>
        $.ajaxSetup({
            headers:{
                'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
            }
        });
        $('#adduser').click((e)=>{
            console.log('gg')
            e.preventDefault()
            $.ajax({
                type: "GET",
                url: `{{route('users.create')}}`,
                success:function (response){
                    console.log('success');
                    $('#content').html(response)


                }
            })
        });


        function edituser(id) {

            $.ajax({
                type: "GET",
                url: "{{url('/admin/users')}}" + "/" + id + "/edit",
                success: function (response) {
                    $('#content').html(response)
                }

            })
        }

    </script>
@endsection
