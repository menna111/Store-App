
<form id="add">
    @csrf
    <div class="form-group">
        <label for="exampleInputName">Name </label>
        <input name="name" type="text" class="form-control" id="exampleInputName" aria-describedby="emailHelp" placeholder="Enter name" @error('name') is-invalid  @enderror>
        @error('name')
        <p class="invalid-feedback">{{$message}}</p>
        @enderror
    </div>


    <div class="form-group">
        <label for="exampleInputEmail1">Email address</label>
        <input name="email" type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email" @error('email') is-invalid  @enderror>

        @error('email')
        <p class="invalid-feedback">{{$message}}</p>
        @enderror
    </div>


    <div class="form-group">
        <label for="exampleInputPassword1">Password</label>
        <input name="password" type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" @error('password') is-invalid  @enderror>
        @error('password')
        <p class="invalid-feedback">{{$message}}</p>
        @enderror
    </div>


    <div class="form-group">
        <label for="exampleInputPassword2">Password confirmation</label>
        <input  name="password_confirmation" type="password" class="form-control" id="exampleInputPassword2" placeholder="Password confirmation" @error('password_confirmation') is-invalid  @enderror>
        @error('password_confirmation')
        <p class="invalid-feedback">{{$message}}</p>
        @enderror
    </div>

    <div class="form-group">
        <label for="exampleInputCountry">Country</label>
        <input  name="country" type="text" class="form-control" id="exampleInputCountry" placeholder="country" @error('country') is-invalid  @enderror>
        @error('country')
        <p class="invalid-feedback">{{$message}}</p>
        @enderror
    </div>

    <div class="form-group">
        <label for="exampleInputCity">city</label>
        <input  name="city" type="text" class="form-control" id="exampleInputCity" placeholder="city" @error('city') is-invalid  @enderror>
        @error('city')
        <p class="invalid-feedback">{{$message}}</p>
        @enderror
    </div>

    <div class="form-group">
        <label for="exampleInputAddress">Address</label>
        <input  name="address" type="text" class="form-control" id="exampleInputAddress" placeholder="address" @error('address') is-invalid  @enderror>
        @error('address')
        <p class="invalid-feedback">{{$message}}</p>
        @enderror
    </div>

    <div class="form-group">
        <label for="exampleInputBirthday">Birthday</label>
        <input  name="birthday" type="date" class="form-control" id="exampleInputBirthday" placeholder="birthday" @error('birthday') is-invalid  @enderror>
        @error('birthday')
        <p class="invalid-feedback">{{$message}}</p>
        @enderror
    </div>

    <div class="form-check">
        <label for="exampleInputgender">Gender</label>

        <br>
        <label class="form-check-label" for="flexRadioDefault1">
        <input  name="gender" type="radio" value="male" class="form-check-input" id="exampleInputgender" placeholder="gender" @error('gender') is-invalid  @enderror>
        Male
<br>
            <label class="form-check-label" for="flexRadioDefault1">
            <input  name="gender" type="radio" value="female" class="form-check-input" id="exampleInputgender" placeholder="gender" @error('gender') is-invalid  @enderror>
            Female

                @error('gender')
        <p class="invalid-feedback">{{$message}}</p>
        @enderror
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
