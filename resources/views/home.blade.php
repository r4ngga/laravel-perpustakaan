@extends('template/main')

@section('title','Home')

@section('container')
<div class="container mt-4 mb-5">
<h2 class="mb-4">Welcome, BacaBuku Home</h2>
  <div class="row">
        @foreach($book as $bk)
    <div class="col-md-4">
        <div class="card mb-3 mr-2 " style="width: 18rem;">
            <div class="card-body">
             <h5 class="card-title">{{$bk->name_book}}</h5>
              <h6 class="card-subtitle mb-2 text-muted">{{$bk->author}}</h6>
              <p class="card-text">Publisher : {{$bk->publisher}}. <br>
                    Time Release : {{$bk->time_release}}. <br>
              </p>
            </div>
        </div>
    </div>
    @endforeach
  </div>
</div>

@endsection
