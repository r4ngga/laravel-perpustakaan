@extends('template/main')

@section('title','Register')

@section('container')
<div class="container mt-4 mb-5">
    <div class="row justify-content-center">
        <div class="col col-lg-6">
            <h3 class="p-2"> Register</h3>
            <div class="card mb-4">
              <div class="card-body">
                @if(session('notify'))
                <div class="alert alert-success my-2" role="alert">
                    {{session('notify')}}
                </div>
                @endif
            <form method="POST" action="{{ route('regist') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                      <label for="Name">Name</label>
                      <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name">
                    @error('name')
                      <div class="invalid-feedback">{{$message}}</div>
                    @enderror
                    </div>
                    <div class="form-group">
                      <label for="Email">Email address</label>
                      <input type="text" class="form-control @error('email') is-invalid @enderror" id="regis_email" name="email">
                    @error('email')
                      <div class="invalid-feedback">{{$message}}</div>
                    @enderror
                    <span id="email-msg" class="text-sm text-gray-600 one-number" style="display: none;">
                        <i class="fas fa-circle" aria-hidden="true"></i>
                        &nbsp;<p id="response-email"></p>
                    </span>

                    </div>
                    <div class="form-group">
                      <label for="Password">Password</label>
                      <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">
                    @error('password')
                      <div class="invalid-feedback">{{$message}}</div>
                    @enderror
                    </div>
                    <div class="form-group">
                      <label for="Address">Address</label>
                      <input type="text" class="form-control @error('address') is-invalid @enderror" id="address" name="address">
                    @error('address')
                      <div class="invalid-feedback">{{$message}}</div>
                    @enderror
                    </div>
                    <div class="form-group">
                      <label for="Phonenumber">Phone Number</label>
                      <input type="text" class="form-control @error('phone_number') is-invalid @enderror" id="regis_phone_number" name="phone_number">
                    @error('phone_number')
                      <div class="invalid-feedback">{{$message}}</div>
                    @enderror
                      <span id="nomer-tlp" class="text-sm text-gray-600 one-number" style="display: none;">
                        <i class="fas fa-circle" aria-hidden="true"></i>
                        &nbsp;<p id="response"></p>
                      </span>

                    </div>
                    <div class="form-group">
                        <label for="Gender">Select Gender</label>
                        <div class="custom-control custom-radio">
                            <input type="radio" id="man" name="gender" value="man" class="custom-control-input @error('gender') is-invalid @enderror">
                            <label class="custom-control-label" for="man">Man</label>
                          </div>
                          <div class="custom-control custom-radio">
                            <input type="radio" id="woman" name="gender" value="woman" class="custom-control-input @error('gender') is-invalid @enderror">
                            <label class="custom-control-label" for="woman">Woman</label>
                            @error('gender')
                            <div class="invalid-feedback">{{$message}}</div>
                            @enderror
                          </div>
                    </div>
                    <div class="form-group form-check">
                    <label class="form-check-label" for="checkregister">Have a account ? Go <a href="{{('/login')}}">Login</a></label>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
              </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    const phoneNumber = document.querySelector("#regis_phone_number");

    phoneNumber.addEventListener("blur", (event) => {
      event.preventDefault();

      const number = phoneNumber.value;
    //   console.log(number);

      $.ajax({
          type: 'POST',
          data: {
            phone_number:number,
            _token: '{{ csrf_token() }}'
          },
          url: "{{ route('validation-phone') }}",
          success: function(e){
            console.log(e);
            if(e.status == true){
                document.getElementById('nomer-tlp').style.display = 'block';
                document.getElementById('nomer-tlp').style.color = '#02b502';
                const responseMessage = document.getElementById('nomer-tlp');
                responseMessage.textContent = e.message;
            }else{
                document.getElementById('nomer-tlp').style.display = 'block';
                document.getElementById('nomer-tlp').style.color = '#e90f10';
                const responseMessage = document.getElementById('nomer-tlp');
                responseMessage.textContent = e.message;
            }
          }
      });

    });

    const getEmail = document.querySelector("#regis_email");

    getEmail.addEventListener("blur", (event) => {
        event.preventDefault();

        const emai = getEmail.value;

        $.ajax({
            type: 'POST',
            data: {email:emai, _token:"{{ csrf_token() }}"},
            url: "{{ route('validation-email') }}",
            success: function(e){
                console.log(e);
                if(e.status == true){
                    document.getElementById('email-msg').style.display = 'block';
                    document.getElementById('email-msg').style.color = '#02b502';
                    const responseMessage = document.getElementById('email-msg');
                    responseMessage.textContent = e.message;
                }else{
                    document.getElementById('email-msg').style.display = 'block';
                    document.getElementById('email-msg').style.color = '#e90f10';
                    const responseMessage = document.getElementById('email-msg');
                    responseMessage.textContent = e.message;
                }
            }
        });
    });
</script>
@endsection
