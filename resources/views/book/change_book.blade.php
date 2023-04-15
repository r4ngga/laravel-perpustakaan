@extends('template/maindashboard')

@section('title','Change Book')

@section('container')
<div class="container mt-3 mb-5">
    <div class="row">
        <div class="col">
            <h3> Change Data Book</h3>

            <div class="card">
                <div class="card-body">
                  <form method="POST" action="/book/update/{{$book->id_book}}" enctype="multipart/form-data">
                  @csrf
                        <div class="form-group">
                            <label for="isbn">ISBN </label>
                            <input type="text" class="form-control @error('isbn') is-invalid @enderror" id="isbn" name="isbn" value="{{$book->isbn}}">
                        @error('isbn')
                            <div class="invalid-feedback">{{$message}}</div>
                        @enderror
                        </div>
                        <div class="form-group">
                            <label for="name">Book Name </label>
                            <input type="text" class="form-control @error('name_book') is-invalid @enderror" id="name_book" name="name_book" value="{{$book->name_book}}">
                        @error('name_book')
                            <div class="invalid-feedback">{{$message}}</div>
                        @enderror
                        </div>
                        <div class="form-group">
                            <label for="author">Author </label>
                            <input type="text" class="form-control @error('author') is-invalid @enderror" id="author" name="author" value="{{$book->author}}">
                        @error('author')
                            <div class="invalid-feedback">{{$message}}</div>
                        @enderror
                        </div>
                        <div class="form-group">
                                <label for="publisher">Publisher </label>
                                <input type="text" class="form-control @error('publisher') is-invalid @enderror" id="publisher" name="publisher"  value="{{$book->publisher}}">
                            @error('publisher')
                                <div class="invalid-feedback">{{$message}}</div>
                            @enderror
                           </div>
                           <div class="form-group">
                                <label for="timerelease">Time Release </label>
                                <input type="text" class="form-control @error('time_release') is-invalid @enderror" id="time_release" name="time_release"  value="{{$book->time_release}}">
                            @error('time_release')
                                <div class="invalid-feedback">{{$message}}</div>
                            @enderror
                           </div>
                            <div class="form-group">
                                <label for="language">Language </label>
                                <input type="text" class="form-control @error('language') is-invalid @enderror" id="language" name="language" value="{{$book->language}}">
                            @error('language')
                                <div class="invalid-feedback">{{$message}}</div>
                            @enderror
                            </div>
                           <div class="form-group">
                                <label for="pages">Book Pages </label>
                                <input type="text" class="form-control @error('pages_book') is-invalid @enderror" id="pages_book" name="pages_book"  value="{{$book->pages_book}}">
                            @error('pages_book')
                                <div class="invalid-feedback">{{$message}}</div>
                            @enderror
                            </div>
                            <div class="form-group">
                                <img src="/images/{{$book->image_book}}" class="img-fluid mb-2" alt="Book Cover" width="200" height="200">
                            </div>
                            <div class="form-group">
                                <label for="image_book">Book Cover </label>
                                <input type="file" class="form-control-file @error('image_book') is-invalid @enderror" id="image_book" name="image_book" value="">
                            @error('image_book')
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
