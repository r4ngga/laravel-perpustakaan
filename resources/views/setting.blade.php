@extends('template/maindashboard')

@section('title','Setting Account')

@section('container')
<div class="container mt-3 mb-5">

    <div class="row justify-content-center">
        <div class="col">
            @php
            $parsing = [
                'list' => array(['href' => route('admin'), 'text'=> 'Beranda', 'is_active' => false ], ['href' => '', 'text' => 'Setting Account', 'is_active' => true]),
                'title' => 'Setting'
            ];
            @endphp
            @include('template.breadcrumb', $parsing)
        </div>
    </div>

    <div class="row">
        <div class="col">
         @if(session('notify'))
            <div class="alert alert-success my-2" role="alert">
                {{session('notify')}}
            </div>
         @endif
        <p><h5> Change Your Data</h5>  <a href="{{('/changepassword')}}" class="btn btn-info">Change Password</a></p>
            <div class="card m-4">
                <div class="card-body">
                  <form method="POST" action="{{('/setting')}}">
                  @csrf
                        <div class="form-group" hidden>
                            <label for="iduser">Id User </label>
                            <input type="text" class="form-control @error('id_user') is-invalid @enderror" id="id_user" name="id_user" value="{{auth()->user()->id_user}}">
                        @error('id_user')
                            <div class="invalid-feedback">{{$message}}</div>
                        @enderror
                        </div>
                        <div class="form-group">
                            <label for="name">Name </label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{auth()->user()->name}}">
                        @error('name')
                            <div class="invalid-feedback">{{$message}}</div>
                        @enderror
                        </div>
                        <div class="form-group">
                            <label for="email">Email </label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{auth()->user()->email}}" readonly>
                        @error('email')
                            <div class="invalid-feedback">{{$message}}</div>
                        @enderror
                        </div>
                        <div class="form-group">
                                <label for="phone_number">Number Phone </label>
                                <input type="text" class="form-control @error('phone_number') is-invalid @enderror" id="phone_number" name="phone_number"  value="{{auth()->user()->phone_number}}">
                            @error('phone_number')
                                <div class="invalid-feedback">{{$message}}</div>
                            @enderror
                           </div>
                           <div class="form-group">
                                <label for="address">Address </label>
                                <input type="text" class="form-control @error('address') is-invalid @enderror" id="address" name="address"  value="{{auth()->user()->address}}">
                            @error('address')
                                <div class="invalid-feedback">{{$message}}</div>
                            @enderror
                           </div>
                           <div class="form-group">
                                <label for="gender">Gender </label>
                                <input type="text" class="form-control @error('gender') is-invalid @enderror" id="gender" name="gender"  value="{{auth()->user()->gender}}" readonly>
                            @error('gender')
                                <div class="invalid-feedback">{{$message}}</div>
                            @enderror
                            </div>
                            <div class="form-group">
                                <label for="role">Role </label>
                                <input type="text" class="form-control @error('role') is-invalid @enderror" id="role" name="role"  value="{{auth()->user()->role}}" readonly>
                             @error('role')
                                <div class="invalid-feedback">{{$message}}</div>
                            @enderror
                            </div>

                        <button type="submit" class="btn btn-primary">Update Data</button>
                  </form>
                </div>
              </div>
        </div>
    </div>
</div>
@endsection()
