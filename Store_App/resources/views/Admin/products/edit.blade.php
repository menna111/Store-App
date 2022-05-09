
        <h1>Edit product</h1>

    </div>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form id="edit" method="POST" action="{{route('products.update',$id)}}">
            @csrf

            <div class="row">
                <div class="col-md-12 mb-3">
                    <label for="">Name</label>
                    <input type="text" class="form-control" name="name" @error('name') is-invalid  @enderror  value="{{$product->name}}">
                    @error('name')
                    <p class="invalid-feedback">{{$message}}</p>
                    @enderror
                </div>

                <div class="col-md-12 mb-3">
                    <label for="">category Id</label>
                    <select  class="form-control" name="category_id" @error('category_id') is-invalid  @enderror>

                        @foreach($categories as $item)
                        <option value="{{$item->id}}"@if ($product->category_id == $item->id) selected  @endif>{{$item->name}}</option>
                        @endforeach
                    </select>
                    @error('category_id')
                    <p class="invalid-feedback">{{$message}}</p>
                    @enderror
                </div>

                <div class="col-md-12 mb-3">
                    <label for="">price</label>
                    <input type="number" class="form-control" name="price" @error('price') is-invalid  @enderror value="{{$product->price}}">

                    @error('price')
                    <p class="invalid-feedback">{{$message}}</p>
                    @enderror
                </div>

                <div class="col-md-12 mb-3">
                    <label for="">sale price</label>
                    <input type="number" class="form-control" name="sale_price" @error('sale_price') is-invalid  @enderror value="{{$product->sale_price}}">

                    @error('sale_price')
                    <p class="invalid-feedback">{{$message}}</p>
                    @enderror
                </div>

                <div class="col-md-12 mb-3">
                    <label for="">Quantity</label>
                    <input type="number" class="form-control" name="quantity" @error('quantity') is-invalid  @enderror value="{{$product->quantity}}">

                    @error('quantity')
                    <p class="invalid-feedback">{{$message}}</p>
                    @enderror
                </div>


                <div class="col-md-12 mb-3">
                    <label for="">Description</label>
                    <textarea name="description" rows="3" @error('description') is-invalid  @enderror class="form-control">{{$product->description}}</textarea>

                    @error('description')
                    <p class="invalid-feedback">{{$message}}</p>
                    @enderror
                </div>

                <div class="col-md-12 mb-3">
                @if($product->image)
                    <img src="{{ asset($product->image) }}" alt="product" height="100px;" width="100px">
                @endif
                </div>

                <div class="col-md-12 mb-3">
                    <label for="">Image</label>
                    <input type="file" class="form-control"  name="image" @error('image') is-invalid  @enderror>

                    @error('image')
                    <p class="invalid-feedback">{{$message}}</p>
                    @enderror
                </div>

                <div class="col-md-12 mb-3">
                    <label for="">Tags</label>
                    @foreach($tags as $tag)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="tag[]" value="{{$tag->id}}"
                            @if(in_array($tag->id,$product_tags)) checked @endif >
                            <label class="form-check-label">{{$tag->name}}</label>
                        </div>
                    @endforeach

                </div>

                <div class="col-md-12 m-3">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>


            </div>

        </form>

</div>

{{--@section('script')--}}
{{--<script>--}}
{{--    $.ajaxSetup({--}}
{{--        headers:{--}}
{{--            'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')--}}
{{--        }--}}
{{--    });--}}

{{--    $('#edit').submit(function (e){--}}
{{--        e.preventDefault();--}}

{{--        var formData = new FormData(this);--}}
{{--        $.ajax({--}}
{{--            console.log('hi')--}}
{{--            method:"POST",--}}
{{--            url:`{{ url('/products/update') }}`/${id},--}}
{{--            data: formData,--}}
{{--            contentType: false,--}}
{{--            processData: false,--}}
{{--            success: function(response) {--}}

{{--                if(response.status == true){--}}
{{--                    Swal.fire({--}}
{{--                        icon: 'success',--}}
{{--                        title: 'success',--}}
{{--                        text: response.msg,--}}
{{--                    })--}}
{{--                    window.location.reload();--}}
{{--                }else{--}}
{{--                    console.log(response.msg);--}}
{{--                    Swal.fire({--}}
{{--                        icon: 'error',--}}
{{--                        title: 'error',--}}
{{--                        text: response.msg,--}}
{{--                    })--}}
{{--                }--}}

{{--            }--}}
{{--        })--}}
{{--    })--}}
{{--</script>--}}
{{--@endsection--}}
