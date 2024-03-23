@extends('template/main')

@section('title','Login')

@section('container')
<div class="container mt-4 mb-4">
    <div class="row justify-content-center">
        <div class="col col-lg-4">
            <div class="card">
              <div class="card-body">
                @if(session('notify'))
                <div class="alert alert-success my-2" role="alert">
                    {{session('notify')}}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="color: black">
                        <span aria-hidden="true">&times;</span>
                    </button>

                </div>
                @endif

                @if(session('error'))
                <div class="alert alert-danger my-2" role="alert">
                    {{session('error')}}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="color: black">
                        <span aria-hidden="true">&times;</span>
                    </button>

                </div>
                @endif

            <form method="POST" action="{{url('login')}}">
                    @csrf
                    <div class="form-group">
                      <label for="Email">Email address</label>
                      <input type="text" class="form-control @error('email') is-invalid @enderror" id="email" name="email">
                    @error('email')
                      <div class="invalid-feedback">{{$message}}</div>
                    @enderror
                    </div>
                    <div class="form-group">
                      <label for="Password">Password</label>
                      <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">
                    @error('password')
                      <div class="invalid-feedback">{{$message}}</div>
                    @enderror
                    </div>
                    <div class="form-group form-check">
                    <label class="form-check-label" for="checkregister">Don't have account ? Go <a href="{{('/register')}}">Register</a></label>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
              </div>
            </div>
        </div>
    </div>
</div>

@endsection
