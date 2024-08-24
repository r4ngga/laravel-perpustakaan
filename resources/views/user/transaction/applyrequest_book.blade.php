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
                                            <div class="py-4 pl-4"><button type="button" onclick="incrementQty()" class="btn btn-primary">+</button></div>
                                            <div class="py-4 px-2">
                                                <input type="text" class="form-control @error('stok') is-invalid @enderror" id="stok" name="stok" value="0" readonly>
                                            </div>
                                            <div class="py-4"><button type="button" onclick="decrementQty()" class="btn btn-md btn-primary">-</button></div>
                                        {{-- </div> --}}
                                    {{-- </div> --}}
                                    
                                    
                                    @error('stok')
                                    <div class="invalid-feedback">{{$message}}</div>
                                    @enderror
                                {{-- </div> --}}
                                {{-- <div class="col"> --}}
                                  <div class="py-4 px-2"> Qty Stok : <span id="qty-stok">  </span></div> 
                                  <div class="py-4 px-3" id="qty-alrt" style="visibility: hidden"> <p id="msg-qty"> </p> </div>
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

$( document ).ready(function() {
    console.log( "ready!" );
    $.ajax({
        type: 'GET',
        url: '/getstock/'+{{ $book->id_book }},
        processdata: false,
        success:function(data){
            document.getElementById('qty-stok').innerHTML = data.stok;
        }
    });

});

    function incrementQty(){
        // e.preventDefault();
        let alert = document.getElementById('qty-alrt');
        let stok = parseInt(document.getElementById('stok').value);
        // let actualstock = parseInt(document.getElementById('qty-stok').innerHTML);
        let actualstock = {{ $book->stok }};
        
        

        stok = isNaN(stok) ? 0 : stok;
        stok++;

        if(stok > actualstock){
            // console.log(actualstock);
            // console.log('too much');
            if(alert.style.visibility === 'hidden'){
            document.getElementById('qty-alrt').style.visibility = 'visible';
            document.getElementById('msg-qty').innerHTML = 'Buku yang disewa lebih <br> dari stok yang tersedia';
            // stok--;
          }
        }
        else if(alert.style.visibility === 'visible'){
            document.getElementById('qty-alrt').style.visibility = 'hidden';
        }        
       
        document.getElementById('stok').value = stok;
        // document.getElementById('qty-stok').innerHTML = after;
    }

    function decrementQty()
    {
        let stock = parseInt(document.getElementById('stok').value);
        let alert = document.getElementById('qty-alrt');

        stock = isNaN(stock) ? 0 : stock; 
        // let default_val = 1;
        if(stock == 0 || stock < 0){
            if(alert.style.visibility === 'hidden'){
            document.getElementById('qty-alrt').style.visibility = 'visible';
            document.getElementById('msg-qty').innerHTML = 'Jumlah tidak boleh negatif';
            }
        }else{
            document.getElementById('qty-alrt').style.visibility = 'hidden';
            stock--;
            // let stok_now = stock - default_val;
            document.getElementById('stok').value = stock;
        }
        
    }
</script>
    
@endsection