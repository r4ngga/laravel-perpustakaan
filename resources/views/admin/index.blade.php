@extends('template/maindashboard')

@section('title','Dashboard')

@section('container')
<div class="container mt-4 mb-5">
    <div class="row justify-content-center">
        <div class="col col-lg-4">
            <div class="card">
              <div class="card-body">
                @if(session('notify'))
                <div class="alert alert-success my-2" role="alert">
                    {{session('notify')}}
                </div>
                @endif
                <p>Welcome {{auth()->user()->name}}</p>
                <p>Admin Dashboard</p>
              </div>
            </div>
        </div>
    </div>
</div>

@endsection
