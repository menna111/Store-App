@extends('Admin.layouts.Admin-dashboard')
@section('title','Categories')
@section('content')
<div class="row">
    <h1>Categories</h1>


    <div >
            @if (session()->has('success'))
                <div class="alert alert-success">
                    {{session()->get('success')}}
                </div>
            @endif
        </div>


            <!-- Button trigger modal -->
       <div>
           <button type="button" class="btn btn-primary m-3" data-bs-toggle="modal" data-bs-target="#category" id="addcategory">
               Add Category
           </button>
       </div>

    <table class="table">
        <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Parent ID</th>
            <th>Description</th>
            <th>Actions</th>
        </tr>
        </thead>

        <tbody>
        @forelse($categories as $category)
        <tr>
            <td>{{$loop->iteration}}</td>
            <td>{{$category->name}}</td>
            <td>{{$category->parent_id}}</td>
            <td>{{$category->description}}</td>

            <td>
                <a href="" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#category"  onclick="editCategory({{$category->id}})">
                    Edit </a>
                <a href="" class="btn btn-danger">Delete</a>

            </td>
        </tr>
        @empty
            <tr>
                <td colspan="3">
                    <p>no category</p>
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>




        <!-- Modal -->
        <div class="modal fade" id="category" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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

        $('#addcategory').click((e)=>{
            e.preventDefault()
            $.ajax({
                type: "GET",
                url: `{{url('categories/create')}}`,
                success:function (response){
                    $('#content').html(response)


                }
            })
        });

        function editCategory(id) {
            $.ajax({
                type: "GET",
                url: `{{url('/categories/edit')}}/${id}`,
                success: function (response) {
                    $('#content').html(response)
                }

            })
        }

    </script>
@endsection
