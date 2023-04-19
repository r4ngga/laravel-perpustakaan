@extends('template/maindashboard')

@section('title','Show all book')
@section('style')
<style>
    .card-total{
        position: absolute;
        /* right: 100%; */
        left: 65%;
        background: #D0D0D0;
        color: black;
        size: 5em;
        width: 100%;
        height: 100%;
        max-width: 10em;
        text-align: center;
        justify-content: space-around;
        /* padding-top: 1px; */
    }

    .mini-img-cover{
        max-width: 100px;
        width: 100%;
        max-height: 100px;
        height: 100%;
    }

    .position-col{
        right: 100%;
    }
</style>
@endsection

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
            <div class="row mb-4">
                <div class="col col-lg-6">
                    <a href="/book/create" class="btn btn-primary my-2"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-lg" viewBox="0 0 16 16">
                        <path d="M8 0a1 1 0 0 1 1 1v6h6a1 1 0 1 1 0 2H9v6a1 1 0 1 1-2 0V9H1a1 1 0 0 1 0-2h6V1a1 1 0 0 1 1-1z"/>
                      </svg> Insert a new book</a>
                </div>
                <div class="col col-lg-6 pt-1">
                    <div class="card card-total">
                        <h5>Total Books {{ $countBook ?? 0 }}</h5>
                    </div>
                </div>
            </div>

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
                    <th scope="col">Id</th>
                    <th scope="col">ISBN</th>
                    <th scope="col">Book Name</th>
                    <th scope="col">Author</th>
                    <th scope="col">Publisher</th>
                    @if($cekrole == 1)
                    <th scope="col" style="text-align: center">Act</th>
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
                        {{-- <a href="/book/edit/{{$bk->id_book}}" class="btn btn-info"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                            <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                            <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                          </svg> </a> --}}
                        {{-- <a onclick="getEdtBook({{ $bk->id_book }},'{{$bk->name_book }}', '{{ $bk->isbn }}','{{$bk->author}}','{{$bk->publisher}}', '{{$bk->time_release}}','{{$bk->pages_book}}','{{$bk->language}}', '{{ $bk->image_book ?? 'default.jpeg'}}')" data-toggle="modal" data-target="#editbook" class="btn btn-sm btn-info"> <i class="fas fa-edit"></i> </a> --}}
                        <a onclick="fetchEdit({{ $bk->id_book }})" data-toggle="modal" data-target="#editbook" class="btn btn-sm btn-info"> <i class="fas fa-edit"></i> </a>
                        <a href="{{$bk->id_book}}/#ComfirmDeleteModal" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#ComfirmDeleteModal{{$bk->id_book}}"> <i class="far fa-trash-alt"></i> </a>
                        <a onclick="fetchShowBook({{ $bk->id_book }})" data-toggle="modal" data-target="#showbook" class="btn btn-sm btn-warning"><i class="fas fa-eye" aria-hidden="true"></i></a>
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
 {{-- @foreach($books as $bk) --}}
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
            <form action="/book/delete" method="POST">
                @csrf
                {{-- @method('delete') --}}
                    <div class="form group">
                        <input type="hidden" name="book_id" id="del-bookid">
                    </div>
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
{{-- @endforeach --}}

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
            <form action="" id="form-edt" method="POST" enctype="multipart/form-data">
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
                    <input type="text" class="form-control" id="name-book" name="name_book" value="" required>
                </div>
                <div class="form-group">
                    <label for="email">Author</label> <span style="color: red;">*</span>
                    <input type="text" name="author" id="author-book" class="form-control" value="" required>
                </div>
                <div class="form-group">
                    <label for="phonenumber">ISBN</label> <span style="color: red;">*</span>
                    <input type="number" name="isbn" id="isbn-book" class="form-control" value="" required>
                </div>
                <div class="form-group">
                    <label for="adress">Publisher</label> <span style="color: red;">*</span>
                    <input type="text" name="publisher" id="publisher-book" class="form-control" value="" required>
                </div>
                <div class="form-group">
                  <label for="timerelease">Time Release</label>
                  <input type="text" name="time_release" id="timerelease-book" class="form-control" value="" required>
                </div>
                <div class="form-group">
                    <label for="password">Pasges Book</label>
                    <input type="text" name="pages_book" id="pages-book" class="form-control" value="">
                </div>
                <div class="form-group">
                    <label for="label">Language</label>
                    <input type="text" name="language" id="language-book" class="form-control" value="">
                </div>
                <div class="form-group ">
                    <label for="forimg">Image Cover Book </label>
                    <img src="" id="img-book" class="mini-img-cover" alt="" style="margin-top: 2px; margin-bottom: 4px;">
                    <input type="file" name="image_book" id="image-book" onchange="previewImage(event);" class="form-control mt-2">
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
                <h5 id="titlecard"></h4>
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
                <div class="row" > <div class="col" style="justify-content: center; align-self: center"> Image Cover Book ; </div>
                <div class="col"> <img id="b-img" class="mini-img-cover" src="" alt=""> </div>
                </div>
                <div class="row">
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
        // const img_book = img_bk;

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

    }

    const previewImage = (event) => { //untuk preview image ketika edit
        /**
       * Get the selected files.
       */
      const imageFiles = event.target.files;
      /**
       * Count the number of files selected.
       */
      const imageFilesLength = imageFiles.length;
      /**
       * If at least one image is selected, then proceed to display the preview.
       */
      /**
       * If at least one image is selected, then proceed to display the preview.
       */
      if (imageFilesLength > 0) {
          /**
           * Get the image path.
           */
          const imageSrc = URL.createObjectURL(imageFiles[0]);
          /**
           * Select the image preview element.
           */
          const imagePreviewElement = document.querySelector("#img-book");
          /**
           * Assign the path to the image preview element.
           */
          imagePreviewElement.src = imageSrc;
          /**
           * Show the element by changing the display value to "block".
           */
          imagePreviewElement.style.display = "block";
      }
    };

    function fetchEdit(id)
    {
        $.ajax({
            type: 'GET',
            url: '/fetchedit/'+id,
            processdata: false,
            // type: 'JSON',
            success:function(data){
                console.log(data);
                document.getElementById('id-book').value = data.id_book;
                document.getElementById('name-book').value = data.name_book;
                document.getElementById('author-book').value = data.author;
                document.getElementById('isbn-book').value = data.isbn;
                document.getElementById('publisher-book').value = data.publisher;
                document.getElementById('timerelease-book').value = data.time_release;
                document.getElementById('pages-book').value = data.pages_book;
                document.getElementById('language-book').value = data.language;
                document.getElementById('img-book').src = data.image_book;
                document.getElementById('img-book').value = "";

            }
        });
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
                },
                success: function(data){
                alert("okay");
                console.log(data);
                },
                error: function(){
                    alert("failure From php side!!! ");
                }
            });
    }

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
        let img_book = $('#image-book').val() ;

        let form = new FormData($("#form-edt")[0]);
        // let replace_name_img = img_book.replace("C:\\fakepath\\","");

        // console.log(replace_name_img);
        $.ajax({
                // method: 'PUT',
                type: 'POST',
                enctype: 'multipart/form-data',
                // url : "{{ route('book.update', "book_id") }}",
                url: '/book/update/'+book_id ,
                headers: {
                'X-CSRF-Token': '{{ csrf_token() }}',
                },
                dataType: 'json',
                processData: false,
                contentType: false,
                data:form,
                // data : {
                //     id_book: book_id,
                //     name_book: book_name,
                //     isbn: book_isbn,
                //     author: author,
                //     publisher: publisher,
                //     time_release: time_release,
                //     pages_book: pages_book,
                //     language: language,
                //     image_book: img_book
                // },
                success: function(data){
                //   console.log(data.data);
                  $('#editbook').modal('hide');

                    $("#aler-success").css("display", "block");
                    // $("#aler-success").append("<p>Success</p>");
                    $("#aler-success").append("<p>"+data.data+"</p>");
                    fetchbook();
                }
            });

        $.ajax();
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
                document.getElementById('titlecard').innerHTML = data.name_book;
                document.getElementById('b-name').innerHTML = data.name_book;
                document.getElementById('b-isbn').innerHTML = data.isbn;
                document.getElementById('b-author').innerHTML = data.author;
                document.getElementById('b-publisher').innerHTML = data.publisher;
                document.getElementById('b-timerelease').innerHTML = data.time_release;
                document.getElementById('b-pagesbook').innerHTML = data.pages_book;
                document.getElementById('b-language').innerHTML = data.language;
                if(!data.image_book )
                {
                    document.getElementById('b-img').src =  '/images/default.jpeg';
                }else{
                document.getElementById('b-img').src =  '/images/'+data.image_book;
            }
                // let create_img = document.createElement("img");
                // create_img.src = '/images/'+data.image_book;
                // let div_img = document.getElementById('b-imgbok');
                // div_img.appendChild(create_img);
            }
        });
    }
</script>
@endsection
