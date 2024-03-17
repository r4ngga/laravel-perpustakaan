@extends('template/maindashboard')

@section('title','Request Borrow Book')

@section('container')
<div class="container mt-4 mb-5">
<h2 class="mb-4">Welcome, BacaBuku Home</h2>

<div class="row justify-content-center">
    <div class="col">
        @php
        $parsing = [
            'list' => array(['href' => route('admin'), 'text'=> 'Beranda', 'is_active' => false ], ['href' => '', 'text' => 'Request Borrow Book', 'is_active' => true]),
            'title' => 'Request Books'
        ];
        @endphp
        @include('template.breadcrumb', $parsing)
    </div>
</div>

@if(session('notify'))
    <div class="alert alert-success my-2" role="alert">
        {{session('notify')}}
    </div>
@endif
  <div class="row">
        @foreach($book as $bk)
    <div class="col-md-4">
        <div class="card mb-3 mr-2 " style="width: 18rem;">
            <div class="card-body">
                <img src="/images/{{$bk->image_book}}" alt="{{$bk->image_book}}" class="img-fluid mb-2" width="200" height="200">
                <h5 class="card-title">{{$bk->name_book}}</h5>
                 <h6 class="card-subtitle mb-2 text-muted">{{$bk->author}}</h6>
                 <p class="card-text">Publisher : {{$bk->publisher}}. <br>
                       ISBN/ISN : {{$bk->isbn}} . <br>
                       Time Release : {{$bk->time_release}}. <br>
                       Language : {{$bk->language}}. <br>
                       <a href="/requestbook/applyrequest/{{$bk->id_book}}" class="btn btn-sm btn-primary">Request Borrow</a>
                 </p>
            </div>
        </div>
    </div>
    @endforeach
  </div>
  <nav aria-label="Page navigation example">
    <ul class="pagination justify-content-center mb-2">
      {{ $book->links() }}
    </ul>
  </nav>
</div>

@endsection
