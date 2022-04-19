@extends('Admin.layouts.Admin-dashboard')
@section('title','products')
@section('main_title','products')
@section('page','products')
@section('content')
<div class="row">

    {{--    <success messages--}}
    @if(session()->has('success'))
        <div class="alert alert-success">
            {{session('success')}}
        </div>
    @endif

{{--            error messages--}}
    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

            <!-- Button trigger modal -->
       <div>
           <a href="{{url('/products/create')}}" class="btn btn-primary m-3 " data-bs-toggle="modal" data-bs-target="#Product" id="addProduct">
               Add Product
           </a>
       </div>



    <table class="table">
        <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Category</th>
            <th>Price</th>
            <th>Sale Price</th>
            <th>Quantity</th>
            <th>Description</th>
            <th>Image</th>

            <th>Actions</th>
        </tr>
        </thead>

        <tbody>
        @forelse($products as $Product)
        <tr>
            <td>{{$loop->iteration}}</td>
            <td>{{$Product->name}}</td>
            <td>{{$Product->category->name}}</td>
            <td>{{$Product->price}}</td>
            <td>{{$Product->sale_price}}</td>
            <td>{{$Product->quantity}}</td>
            <td>{{$Product->description}}</td>
            <td><img src="{{ asset($Product->image) }}" alt="product" height="100px;" width="100px"> </td>

            <td>
                <a href="" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#Product"  onclick="editProduct({{$Product->id}})">
                    Edit </a>
                <a href="{{route('products.delete',$Product->id)}}" class="btn btn-danger">Delete</a>

            </td>
        </tr>
        @empty
            <tr>
                <td colspan="9" class="text-center">
                    <p>no Product</p>
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>




        <!-- Modal -->
        <div class="modal fade" id="Product" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
        $('#addProduct').click((e)=>{
            console.log('gg')
            e.preventDefault()
            $.ajax({
                type: "GET",
                url: `{{route('products.create')}}`,
                success:function (response){
                    console.log('success');
                    $('#content').html(response)


                }
            })
        });


        function editProduct(id) {

            $.ajax({
                type: "GET",
                url: "{{url('admin/products')}}" + "/" + id + "/edit",
                success: function (response) {
                    $('#content').html(response)
                }

            })
        }

    </script>
@endsection
