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
                    @if($cekrole == "admin")
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
                    @if($cekrole == "admin")
                    <td>
                        <a href="/book/changebook/{{$bk->id_book}}" class="btn btn-info"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
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
@endsection()

<script>

</script>
