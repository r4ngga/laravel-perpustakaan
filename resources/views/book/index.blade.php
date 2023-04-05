@extends('template/maindashboard')

@section('title','Show all book')

@section('container')
<div class="container mt-3 mb-5">
    <div class="row justify-content-center">
        <div class="col">
            @php
            $parsing = [
                'list' => array(['href' => route('admin'), 'text'=> 'Beranda', 'is_active' => false ], ['href' => '', 'text' => 'Book', 'is_active' => true]),
                'title' => 'All Books'
            ];
            @endphp
            @include('template.breadcrumb', $parsing)
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col">
            <h3> All Book</h3>
            <?php
            $cekrole = auth()->user()->role
            ?>
            @if($cekrole == "1")
            <a href="/book/create" class="btn btn-primary my-2"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-lg" viewBox="0 0 16 16">
                <path d="M8 0a1 1 0 0 1 1 1v6h6a1 1 0 1 1 0 2H9v6a1 1 0 1 1-2 0V9H1a1 1 0 0 1 0-2h6V1a1 1 0 0 1 1-1z"/>
              </svg> Insert a new book</a>
            @endif
            @if(session('notify'))
            <div class="alert alert-success my-2" role="alert" style="display: {{ session('notify') ? 'block' : 'none'}}">
                {{session('notify')}}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="color: black">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
             @endif

             <div id="aler-success" class="alert alert-success my-2" role="alert" style="display: none">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="color: black">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <table class="table table-bordered border-1 mb-2" id="tableBook">
                <thead>
                  <tr>
                    <th scope="col">Id Book</th>
                    <th scope="col">ISBN</th>
                    <th scope="col">Book Name</th>
                    <th scope="col">Author</th>
                    <th scope="col">Publisher</th>
                    @if($cekrole == 1)
                    <th scope="col">Act</th>
                    @endif
                  </tr>
                </thead>
                <tbody id="row-table-book">
                    @foreach($books as $bk)
                  <tr>
                    <th scope="row">{{$bk->id_book ?? ''}}</th>
                    <td>{{$bk->isbn ?? ''}}</td>
                    <td>{{$bk->name_book ?? ''}}</td>
                    <td>{{$bk->author ?? ''}}</td>
                    <td>{{$bk->publisher ?? ''}}</td>
                    @if($cekrole == "1")
                    <td>
                        {{-- <a href="/book/changebook/{{$bk->id_book}}" class="btn btn-info"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                            <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                            <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                          </svg> </a> --}}
                        <a onclick="getEdtBook({{ $bk->id_book }},'{{$bk->name_book }}', '{{ $bk->isbn }}','{{$bk->author}}','{{$bk->publisher}}', '{{$bk->time_release}}','{{$bk->pages_book}}','{{$bk->language}}')" data-toggle="modal" data-target="#editbook" class="btn btn-sm btn-info"> <i class="fas fa-edit"></i> </a>
                        <a href="{{$bk->id_book}}/#ComfirmDeleteModal" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#ComfirmDeleteModal{{$bk->id_book}}"> <i class="far fa-trash-alt"></i> </a>
                        <a href="#" onclick="fetchShowBook({{ $bk->id_book }})" data-toggle="modal" data-target="#showbook" class="btn btn-sm btn-warning">Show a Detail</a>
                    </td>
                    @endif
                  </tr>
                  @endforeach
                </tbody>
              </table>
        </div>
    </div>
</div>

 <!-- Modal -->
 @foreach($books as $bk)
 <div class="modal fade" id="ComfirmDeleteModal{{$bk->id_book}}" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Warning</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form action="/book/{{$bk->id_book}}" method="POST">
                @csrf
                {{-- @method('delete') --}}
                    <div class="form-group">
                            <label for="pages">Are you sure delete? Please Type "Delete" or "delete" </label>
                            {{-- <input type="text" class="form-control" name="id_book" id="id_book" value="{{$bk->id_book}}" hidden> --}}
                            <input type="text" class="form-control" id="validation" name="validation" placeholder="Type here">
                    </div>
                    <button type="submit" class="btn btn-primary">Confirm</button>
            </form>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
</div>
@endforeach

<div class="modal fade" id="editbook" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Edit a book</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body m-2">
            <form action="" method="POST" enctype="multipart/form-data">
                @csrf
                @method('post')
                {{-- @method('delete') --}}
                {{-- <div class="form-group">
                            <label for="pages">Are you sure delete? Please Type "Delete" or "delete" </label>
                            <input type="text" class="form-control" id="validation" name="validation" placeholder="Type here">
                </div> --}}
                <input type="hidden" id="id-book" value="">

                <div class="form-group">
                    <label for="name">Name</label> <span style="color: red;">*</span>
                    <input type="text" class="form-control" id="name-book" name="name" value="" required>
                </div>
                <div class="form-group">
                    <label for="email">Author</label> <span style="color: red;">*</span>
                    <input type="text" name="email" id="author-book" class="form-control" value="" required>
                </div>
                <div class="form-group">
                    <label for="phonenumber">ISBN</label> <span style="color: red;">*</span>
                    <input type="number" name="phone_number" id="isbn-book" class="form-control" value="" required>
                </div>
                <div class="form-group">
                    <label for="adress">Publisher</label> <span style="color: red;">*</span>
                    <input type="text" name="address" id="publisher-book" class="form-control" value="" required>
                </div>
                <div class="form-group">
                  <label for="timerelease">Time Release</label>
                  <input type="text" name="time_release" id="timerelease-book" class="form-control" value="" required>
                </div>
                <div class="form-group">
                    <label for="password">Pasges Book</label>
                    <input type="text" name="pages" id="pages-book" class="form-control" value="">
                </div>
                <div class="form-group">
                    <label for="label">Language</label>
                    <input type="text" name="language" id="language-book" class="form-control" value="">
                </div>
                <button type="submit" id="btn-edtbook" class="btn btn-primary">Confirm</button>
            </form>

        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
</div>

<div class="modal fade" id="showbook" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Detail a book</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body m-2">
            <div class="card">
              <div class="card-header">

              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col"> Name Book : </div>
                  <div class="col"> <p id="b-name"></p> </div>
                </div>
                <div class="row">
                  <div class="col"> ISBN : </div>
                  <div class="col"> <p id="b-isbn"></p> </div>
                </div>
                <div class="row">
                  <div class="col"> Author : </div>
                  <div class="col"> <p id="b-author"></p></div>
                </div>
                <div class="row">
                  <div class="col"> Publisher :</div>
                  <div class="col"> <p id="b-publisher"></p></div>
                </div>
                <div class="row">
                   <div class="col"> Time Release :  </div>
                   <div class="col"> <p id="b-timerelease"></p></div>
                </div>
                <div class="row">
                  <div class="col"> Pages Book :</div>
                  <div class="col"> <p id="b-pagesbook"></p></div>
                </div>
                <div class="row">
                  <div class="col"> Language :</div>
                  <div class="col"> <p id="b-language"></p> </div>
                </div>
                <div class="row"> <div class="col"> Image Cover Book ; </div></div>
                <div class="row"> <div class="b-imgbok"></div>
                </div>
              </div>
            </div>

        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
</div>

@endsection()

@section('scripts')
<script>
    function getEdtBook(id, nm, isbn, authr, publish, time, pages, lang){
        const book_id = id;
        const book_name = nm;
        const book_isbn = isbn;
        const author = authr;
        const publisher = publish;
        const time_release = time;
        const pages_book = pages;
        const language = lang;

        // let url = '/book/update/'+book_id+'';

        console.log(book_id, book_name, book_isbn, author, publisher, time_release, pages_book, language);
        document.getElementById('id-book').value = book_id;
        document.getElementById('name-book').value = book_name;
        document.getElementById('author-book').value = author;
        document.getElementById('isbn-book').value = isbn;
        document.getElementById('publisher-book').value = publish;
        document.getElementById('timerelease-book').value = time;
        document.getElementById('pages-book').value = pages;
        document.getElementById('language-book').value = lang;

       var click = document.getElementById("btn-edtbook").onclick;

        // if(click){
        //     // document.getElementById("btn-edtbook").onclick = function() {
        //         editApi(book_id, book_name, book_isbn, author, publisher, time_release, pages_book, language);
        //     // };
        // }

         //route to update
        // alert("Form action changed to "+act);
        // document.getElementById("editbook").classList.add("show");
        // document.querySelector(".modal").classList.add("show");

        // var modal = document.querySelector(".modal");
        // var container = modal.querySelector(".container");

        // document.querySelector("button").addEventListener("click", function (e) {
        // modal.classList.remove("hidden")
        // });

        // document.querySelector(".modal").addEventListener("click", function (e) {
        // if (e.target !== modal && e.target !== container) return;
        // modal.classList.add("hidden");
        // });
    }

    function editApi(book_id, book_name, book_isbn, author, publisher, time_release, pages_book, language){
    //     // let values =
            $.ajax({
                type: 'PUT',
                enctype: 'multipart/form-data',
                // url : '{{ url("/book/update/'+book_id+'") }}',
                url: '/book/update/'+book_id ,
                headers: {
                'X-CSRF-Token': '{{ csrf_token() }}',
                },
                data : {
                    id_book: book_id,
                    name_book: book_name,
                    isbn: book_isbn,
                    author: author,
                    publisher: publisher,
                    time_release: time_release,
                    pages_book: pages_book,
                    language: language
                },success: function(data){
                alert("okay");
                console.log(data);
                },
                error: function(){
                    alert("failure From php side!!! ");
                }
            });
    }

    // function sendUpdate(){
    //     let book_id = document.getElementById('name-book').value;
    //     let book_name = document.getElementById('name-book').value;
    //     let book_isbn = document.getElementById('isbn-book').value;
    //     let author = document.getElementById('author-book').value;
    //     let publisher = document.getElementById('publisher-book').value;
    //     let time_release = document.getElementById('timerelease-book').value;
    //     let pages_book = document.getElementById('pages-book').value;
    //     let language = document.getElementById('language-book').value;

    //     $.ajax({
    //             type: 'PUT',
    //             // enctype: 'multipart/form-data',
    //             url : "{{ route('book.update', "book_id") }}",
    //             // url: '/book/update/'+book_id ,
    //             headers: {
    //             'X-CSRF-Token': '{{ csrf_token() }}',
    //             },
    //             data : {
    //                 id_book: book_id,
    //                 name_book: book_name,
    //                 isbn: book_isbn,
    //                 author: author,
    //                 publisher: publisher,
    //                 time_release: time_release,
    //                 pages_book: pages_book,
    //                 language: language
    //             },success: function(data){
    //             alert("okay");
    //             console.log(data);
    //             },
    //             error: function(){
    //                 alert("failure From php side!!! ");
    //             }
    //         });
    // }
    $("#btn-edtbook").click(function(e) {
        e.preventDefault();

        let book_id = $('#id-book').val();
        let book_name = $('#name-book').val();
        let book_isbn = $('#isbn-book').val();
        let author = $('#author-book').val();
        let publisher = $('#publisher-book').val();
        let time_release = $('#timerelease-book').val();
        let pages_book = $('#pages-book').val();
        let language = $('#language-book').val();

        $.ajax({
                // method: 'PUT',
                type: 'POST',
                // enctype: 'multipart/form-data',
                // url : "{{ route('book.update', "book_id") }}",
                url: '/book/update/'+book_id ,
                headers: {
                'X-CSRF-Token': '{{ csrf_token() }}',
                },
                processdata: false,
                data : {
                    id_book: book_id,
                    name_book: book_name,
                    isbn: book_isbn,
                    author: author,
                    publisher: publisher,
                    time_release: time_release,
                    pages_book: pages_book,
                    language: language
                },
                success: function(data){
                  console.log(data.data);
                  $('#editbook').modal('hide');
                //   location.href = '/book';
                //   window.location.reload();
                    $("#aler-success").css("display", "block");
                    // $("#aler-success").append("<p>Success</p>");
                    $("#aler-success").append("<p>"+data.data+"</p>");
                    fetchbook();
                }
            });
    });

    function fetchbook(){
        $.ajax({
            type: 'GET',
            url: '{{ route('book.fetch-index') }}',
            processdata: false,
            success:function(data){
                // console.log(data);
                $('#row-table-book').html(data.html);
            }
        });
    }

    function fetchShowBook(id){
        $.ajax({
            type: 'GET',
            url: '/book/'+id,
            processdata: false,
            // type: 'JSON',
            success:function(data){
                console.log(data);
            }
        });
    }
</script>
@endsection
