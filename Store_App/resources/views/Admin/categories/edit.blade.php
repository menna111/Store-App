
        <h1>Edit Category</h1>

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
        <form id="edit" method="POST" action="{{route('categories.update',$id)}}">
            @csrf

            <div class="row">
                <div class="col-md-12 mb-3">
                    <label for="">Name</label>
                    <input type="text" class="form-control" name="name" value="{{$category->name}}">
                </div>

                <div class="col-md-12 mb-3">
                    <label for="">Parent Id</label>
                    <select  class="form-control" name="parent_id">
                        <option value="">No Parent</option>
                        @foreach($categories as $cat)
                        <option value="{{$cat->id}}" @if($cat->id ==$category->id) selected  @endif>{{$cat->name}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-12 mb-3">
                    <label for="">Description</label>
                    <textarea name="description" rows="3" class="form-control">{{$category->description}}</textarea>
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
{{--            url:`{{ url('/categories/update') }}`/${id},--}}
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
