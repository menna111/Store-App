
<div class="card">
    <div class="card-header">
        <h1>Add Category</h1>

    </div>
    <div class="card-body">
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
                    <input type="text" class="form-control" name="name">
                </div>

                <div class="col-md-12 mb-3">
                    <label for="">Parent Id</label>
                    <select  class="form-control" name="parent_id">
                        <option value="null">No Parent</option>
                        @foreach($categories as $cat)
                        <option value="{{$cat->id}}">{{$cat->name}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-12 mb-3">
                    <label for="">Description</label>
                    <textarea name="description" rows="3" class="form-control"></textarea>
                </div>

                <div class="col-md-12 m-3">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>


            </div>
            @csrf

        </form>
    </div>
</div>

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
            url:"{{ url('/categories/store') }}",
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
