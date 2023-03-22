@extends('template/maindashboard')

@section('title','Change Password')

@section('container')
<div class="container mt-3 mb-5">

    <div class="row justify-content-center">
        <div class="col">
            @php
            $parsing = [
                'list' => array(['href' => route('admin'), 'text'=> 'Beranda', 'is_active' => false ], ['href' => route('setting'), 'text' => 'Setting Account', 'is_active' => false], ['href' => '', 'text' => 'Change Password', 'is_active' => true]),
                'title' => 'Change Password'
            ];
            @endphp
            @include('template.breadcrumb', $parsing)
        </div>
    </div>

    <div class="row">
        <div class="col">
            <h3> Change Password</h3>
            @if(session('notify'))
            <div class="alert alert-success my-2" role="alert">
                {{session('notify')}}
            </div>
            @endif
            <div class="card">
                <div class="card-body">
                  <form method="POST" action="">
                  @csrf
                        <div class="form-group">
                            <label for="new password">New Password </label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" value="">
                        @error('password')
                            <div class="invalid-feedback">{{$message}}</div>
                        @enderror
                        </div>
                        <div class="form-group">
                            <label for="reply password">Reply Password </label>
                            <input type="password" class="form-control @error('reply password') is-invalid @enderror" id="reply_password" name="reply_password" value="">
                        @error('reply password')
                            <div class="invalid-feedback">{{$message}}</div>
                        @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Change Password</button>
                  </form>
                  <a href="{{('/setting')}}" class="btn btn-secondary mt-2">Back to Setting</a>
                </div>
              </div>
        </div>
    </div>
</div>
@endsection()
