
<form id="add">
    @csrf
    <div class="form-group">
        <label for="exampleInputName">Name </label>
        <input name="name" type="text" class="form-control" id="exampleInputName" aria-describedby="emailHelp" placeholder="Enter email">
    </div>
    <div class="form-group">
        <label for="exampleInputEmail1">Email address</label>
        <input name="email" type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
    </div>
    <div class="form-group">
        <label for="exampleInputPassword1">Password</label>
        <input name="password" type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
    </div>
    <div class="form-group">
        <label for="exampleInputPassword2">Password confirmation</label>
        <input  name="password_confirmation" type="password" class="form-control" id="exampleInputPassword2" placeholder="Password confirmation">
    </div>

    <button type="submit" class="btn btn-primary">Submit</button>
</form>

<script>

    $.ajaxSetup({
        headers:{
            'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#add').submit(function (e){
        e.preventDefault();

        console.log('hi');


        var formData = new FormData(this);

        $.ajax({
            type: "POST",
            url: `{{route('users.store')}}`,
            data: formData,
            contentType: false,
            processData: false,

            success: function(response) {
                console.log(response)
                if(response.status == true){
                    Swal.fire({
                        icon: 'success',
                        title: 'success',
                        text: response.msg,
                    })
                    window.location.reload()
                }else{
                    // alert(response.msg);
                    Swal.fire({
                        icon: 'error',
                        title: 'error',
                        text: response.msg,
                    })
                }

            }
        } )

    })
</script>
