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
            @if($bk->image_book)
            <img src="/images/{{$bk->image_book}}" alt="{{$bk->image_book}}" class="img-fluid mb-2" width="200" height="200">
            @else
            <img src="/images/default.jpeg" alt="default-book" class="img-fluid mb-2" width="200" height="200">
            @endif
            <h5 class="card-title">{{$bk->name_book}}</h5>
              <h6 class="card-subtitle mb-2 text-muted">{{$bk->author}}</h6>
              <p class="card-text">Publisher : {{$bk->publisher}}. <br>
                    ISBN/ISN : {{$bk->isbn}} . <br>
                    Time Release : {{$bk->time_release}}. <br>
                    Language : {{$bk->language}}. <br>
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
