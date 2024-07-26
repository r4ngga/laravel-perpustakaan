@extends('template/maindashboard')

@section('title','Apply Request Book')

@section('container')
<div class="container mt-3 mb-5">

    <div class="row justify-content-center">
        <div class="col">
            @php
            $parsing = [
                'list' => array(['href' => route('admin'), 'text'=> 'Beranda', 'is_active' => false ], ['href' => '', 'text' => 'Request Book', 'is_active' => true]),
                'title' => 'Apply Request Book'
            ];
            @endphp
            @include('template.breadcrumb', $parsing)
        </div>
    </div>

    <div class="row">
        <div class="col">
            <h3>Request a Borrow Some Book</h3>
            <div class="card">
                <div class="card-body">
                  <form method="POST" action="/requestbook/applyrequest">
                  @csrf
                        <div class="form-group">
                            <label for="name">Code Request </label>
                            <input type="text" class="form-control @error('code_request') is-invalid @enderror" id="code_request" name="code_request" value="{{$set_value}}" readonly>
                        @error('code_request')
                            <div class="invalid-feedback">{{$message}}</div>
                        @enderror
                        </div>
                        <div class="form-group">
                            <label for="id_user">Id User </label>
                            <input type="text" class="form-control @error('id_user') is-invalid @enderror" id="id_user" name="id_user" value="{{auth()->user()->id_user}}" readonly>
                        @error('id_user')
                            <div class="invalid-feedback">{{$message}}</div>
                        @enderror
                        </div>
                        <div class="form-group">
                            <label for="name">Name </label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{auth()->user()->name}}" readonly>
                        @error('name')
                            <div class="invalid-feedback">{{$message}}</div>
                        @enderror
                        </div>
                        <div class="form-group">
                            <label for="id_book">Id Book </label>
                            <input type="text" class="form-control @error('id_book') is-invalid @enderror" id="id_book" name="id_book" value="{{$book->id_book}}" readonly>
                        @error('id_book')
                            <div class="invalid-feedback">{{$message}}</div>
                        @enderror
                        </div>
                        <div class="form-group">
                            <label for="name">Book Name </label>
                            <input type="text" class="form-control @error('name_book') is-invalid @enderror" id="name_book" name="name_book" value="{{$book->name_book}}" readonly>
                        @error('name_book')
                            <div class="invalid-feedback">{{$message}}</div>
                        @enderror
                        </div>
                        <div class="form-group">
                            <label for="author">Author </label>
                            <input type="text" class="form-control @error('author') is-invalid @enderror" id="author" name="author" value="{{$book->author}}" readonly>
                        @error('author')
                            <div class="invalid-feedback">{{$message}}</div>
                        @enderror
                        </div>
                        <div class="form-group">
                            <label for="publisher">Publisher </label>
                            <input type="text" class="form-control @error('publisher') is-invalid @enderror" id="publisher" name="publisher" value="{{$book->publisher}}" readonly>
                        @error('publisher')
                            <div class="invalid-feedback">{{$message}}</div>
                        @enderror
                        </div>
                        <div class="form-group">
                            <label for="sotk">Stokc</label>
                            <div class="row">
                                {{-- <div class="col"> --}}
                                    {{-- <div class="row"> --}}
                                        {{-- <div class=""> --}}
                                            <div class="py-4 pl-4"><button class="btn btn-primary">+</button></div>
                                            <div class="py-4 px-2">
                                                <input type="text" class="form-control @error('stok') is-invalid @enderror" id="stok" name="stok" value="{{$book->stok}}" readonly>
                                            </div>
                                            <div class="py-4"><button class="btn btn-md btn-primary">-</button></div>
                                        {{-- </div> --}}
                                    {{-- </div> --}}
                                    
                                    
                                    @error('stok')
                                    <div class="invalid-feedback">{{$message}}</div>
                                    @enderror
                                {{-- </div> --}}
                                {{-- <div class="col"> --}}
                                  <div class="py-4 px-2"> Qty Stok : <span id="qty-stok"> 0 </span></div> 
                                  <div class="py-4 px-3" id="qty-alrt" style="visibility: hidden"> <p> Jumlah tidak boleh negatif</p> </div>
                                {{-- </div> --}}
                            </div>
                            
                        </div>
                        <div class="form-group">
                                <label for="name">Time Request </label>
                                <input type="date" class="form-control @error('name_book') is-invalid @enderror" id="time_request" name="time_request" >
                        @error('name_book')
                                <div class="invalid-feedback">{{$message}}</div>
                         @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">Send Request</button>
                        <a href="{{('/requestbook')}}" class="btn btn-warning">Back</a>
                  </form>
                </div>
              </div>
        </div>
    </div>
</div>
@endsection()

@section('scripts')
<script type="text/javascript">
    function incrementQty(){
        let stok = document.getElementById('stok').value;
        let default_val = 0;
        default_val = default_val + 1;
        stok = default_val;
    }

    function decrementQty()
    {
        let stock = document.getElementById('stok').value;
        let default_val = 1;
        if(stock == 0 || stock < 0){
            document.getElementById('qty-alrt').style('visibility') = 'block';
        }else{
            document.getElementById('qty-alrt').style('visibility') = 'hidden';
            let stok_now = stock - default_val;
            document.getElementById('stok').value = stok_now;
        }
        
    }
</script>
    
@endsection