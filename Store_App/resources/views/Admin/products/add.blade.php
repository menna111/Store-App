
        <h1>Create Product</h1>

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
        <form id="add" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-12 mb-3">
                    <label for="">Name</label>
                    <input type="text" class="form-control" name="name" value="{{old('name')}}" @error('name') is-invalid  @enderror >
                    @error('name')
                    <p class="invalid-feedback">{{$message}}</p>
                    @enderror

                </div>

                <div class="col-md-12 mb-3">
                    <label for="">category </label>
                    <select  class="form-control" name="category_id" @error('category_id') is-invalid  @enderror >

                        @error('category_id')
                        <p class="invalid-feedback">{{$message}}</p>
                        @enderror
                        @foreach($categories as $item)
                        <option value="{{$item->id}}" >{{$item->name}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-12 mb-3">
                    <label for="">Price</label>
                    <input type="number" class="form-control" name="price" value="{{old('price')}}" @error('price') is-invalid  @enderror >
                    @error('price')
                    <p class="invalid-feedback">{{$message}}</p>
                    @enderror

                </div>

                <div class="col-md-12 mb-3">
                    <label for="">Sale Price</label>
                    <input type="number" class="form-control" name="sale_price" value="{{old('price')}}" @error('sale_') is-invalid  @enderror >
                    @error('sale_price')
                    <p class="invalid-feedback">{{$message}}</p>
                    @enderror

                </div>


                <div class="col-md-12 mb-3">
                    <label for="">Quantity</label>
                    <input type="number" class="form-control" name="quantity" value="{{old('quantity')}}" @error('quantity') is-invalid  @enderror >
                    @error('quantity')
                    <p class="invalid-feedback">{{$message}}</p>
                    @enderror

                </div>

                <div class="col-md-12 mb-3">
                    <label for="">Description</label>
                    <textarea name="description" rows="3" class="form-control" @error('description') is-invalid  @enderror></textarea>

                    @error('description')
                    <p class="invalid-feedback">{{$message}}</p>
                    @enderror
                </div>

                <label for="">Image</label>
                <input type="file" name="image"  @error('image') is-invalid  @enderror >

                @error('description')
                <p class="invalid-feedback">{{$message}}</p>
                @enderror
            </div>

            <div>
                <div class="col-md-12 mb-3">
                    <label for="">Tags</label>
                    @foreach($tags as $tag)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="tag[]" value="{{$tag->id}}">
                         <label class="form-check-label">{{$tag->name}}</label>
                        </div>
                    @endforeach

                </div>

                </div>

            <input type="hidden" value="{{\Illuminate\Support\Facades\Auth::id()}}" name="user_id">

                <div class="col-md-12 m-3">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>


            </div>
            @csrf

        </form>

</div>
    {{--@endsection--}}

<script>
    $.ajaxSetup({
        headers:{
            'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#add').submit(function (e){
        e.preventDefault();

        var formData = new FormData(this);
        $.ajax({
            method:"POST",
            url:"{{ route('products.store') }}",
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {

                if(response.status == true){
                    Swal.fire({
                        icon: 'success',
                        title: 'success',
                        text: response.msg,
                    })
                    window.location.reload();
                }else{
                    console.log(response.msg);
                    Swal.fire({
                        icon: 'error',
                        title: 'error',
                        text: response.msg,
                    })
                }

            }
        })
    })
</script>
