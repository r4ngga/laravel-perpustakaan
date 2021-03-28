@extends('template/maindashboard')

@section('title','Show all book')

@section('container')
<div class="container mt-3 mb-5">
    <div class="row justify-content-center">
        <div class="col">
            <h3> All Book</h3>
            <?php
            $cekrole = auth()->user()->role
            ?>
            @if($cekrole == "admin")
            <a href="/book/addbook" class="btn btn-primary my-2">Insert a new book</a>
            @endif
            @if(session('notify'))
            <div class="alert alert-success my-2" role="alert">
                {{session('notify')}}
            </div>
             @endif
            <table class="table">
                <thead>
                  <tr>
                    <th scope="col">Id Book</th>
                    <th scope="col">Book Name</th>
                    <th scope="col">Author</th>
                    <th scope="col">Publisher</th>
                    <th scope="col">Time Release</th>
                    <th scope="col">Book Pages</th>
                    @if($cekrole == "admin")
                    <th scope="col">Act</th>
                    @endif
                  </tr>
                </thead>
                <tbody>
                    @foreach($book as $bk)
                  <tr>
                    <th scope="row">{{$bk->id_book}}</th>
                    <td>{{$bk->name_book}}</td>
                    <td>{{$bk->author}}</td>
                    <td>{{$bk->publisher}}</td>
                    <td>{{$bk->time_release}}</td>
                    <td>{{$bk->pages_book}}</td>
                    @if($cekrole == "admin")
                    <td>
                        <a href="/book/changebook/{{$bk->id_book}}" class="btn btn-info">Change</a>
                        <a href="{{$bk->id_book}}/#ComfirmDeleteModal" class="btn btn-danger" data-toggle="modal" data-target="#ComfirmDeleteModal{{$bk->id_book}}">Delete</a>

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
 @foreach($book as $bk)
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
