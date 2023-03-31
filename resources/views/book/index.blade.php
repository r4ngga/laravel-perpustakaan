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
            <a href="/book/addbook" class="btn btn-primary my-2"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-lg" viewBox="0 0 16 16">
                <path d="M8 0a1 1 0 0 1 1 1v6h6a1 1 0 1 1 0 2H9v6a1 1 0 1 1-2 0V9H1a1 1 0 0 1 0-2h6V1a1 1 0 0 1 1-1z"/>
              </svg> Insert a new book</a>
            @endif
            @if(session('notify'))
            <div class="alert alert-success my-2" role="alert">
                {{session('notify')}}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="color: black">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
             @endif
            <table class="table table-bordered border-1 mb-2" id="tableBook">
                <thead>
                  <tr>
                    <th scope="col">Id Book</th>
                    <th scope="col">ISBN</th>
                    <th scope="col">Book Name</th>
                    <th scope="col">Author</th>
                    <th scope="col">Publisher</th>
                    <th scope="col">Time Release</th>
                    <th scope="col">Book Pages</th>
                    <th scope="col">Language</th>
                    @if($cekrole == 1)
                    <th scope="col">Act</th>
                    @endif
                  </tr>
                </thead>
                <tbody>
                    @foreach($books as $bk)
                  <tr>
                    <th scope="row">{{$bk->id_book ?? ''}}</th>
                    <td>{{$bk->isbn ?? ''}}</td>
                    <td>{{$bk->name_book ?? ''}}</td>
                    <td>{{$bk->author ?? ''}}</td>
                    <td>{{$bk->publisher ?? ''}}</td>
                    <td>{{$bk->time_release ?? ''}}</td>
                    <td>{{$bk->pages_book ?? ''}}</td>
                    <td>{{$bk->language ?? ''}}</td>
                    @if($cekrole == "1")
                    <td>
                        {{-- <a href="/book/changebook/{{$bk->id_book}}" class="btn btn-info"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                            <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                            <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                          </svg> </a> --}}
                        <a onclick="getEdtBook({{ $bk->id_book }},'{{$bk->name_book }}', '{{ $bk->isbn }}','{{$bk->author}}','{{$bk->publisher}}', '{{$bk->time_release}}','{{$bk->pages_book}}','{{$bk->language}}')" data-toggle="modal" data-target="#editbook" class="btn btn-info"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                            <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                            <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                          </svg> </a>
                        <a href="{{$bk->id_book}}/#ComfirmDeleteModal" class="btn btn-danger" data-toggle="modal" data-target="#ComfirmDeleteModal{{$bk->id_book}}"> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                            <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                            <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                          </svg></a>
                        <a href="#" class="btn btn-warning">Show a Detail</a>
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
                <button type="submit" class="btn btn-primary">Confirm</button>
            </form>

        </div>
        <div class="modal-footer">
          <button  id="btn-edtbook" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
</div>

@endsection()

@section('scripts')
<script>
    function getEdtBook(id, nm, isbn, authr, publish, time, pages, lang){
        let book_id = id;
        let book_name = nm;
        let book_isbn = isbn;
        let author = authr;
        let publisher = publish;
        let time_release = time;
        let pages_book = pages;
        let language = lang;

        let url = '/book/update/'+book_id+'';

        console.log(book_id, book_name, book_isbn, author, publisher, time_release, pages_book, language);
        document.getElementById('name-book').value = book_name;
        document.getElementById('author-book').value = author;
        document.getElementById('isbn-book').value = isbn;
        document.getElementById('publisher-book').value = publish;
        document.getElementById('timerelease-book').value = time;
        document.getElementById('pages-book').value = pages;
        document.getElementById('language-book').value = lang;

        if(book_id){
            editApi(book_id, book_name, book_isbn, author, publisher, time_release, pages_book, language);
        }

        var clicked = document.getElementById("btn-edtbook").onclick = function () {
            document.getElementById("editbook").action = url;
            // alert('button was click');
        };
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
        // let values =
        $.ajax({
            url : '{{ url("/book/update/'+book_id+'") }}',
            data :
        });
    }
</script>
@endsection
