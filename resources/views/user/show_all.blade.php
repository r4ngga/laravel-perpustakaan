@extends('template/maindashboard')

@section('title','Show all user')

@section('container')
<div class="container mt-3 mb-5">

    <div class="row justify-content-center">
        <div class="col">
            @php
            $parsing = [
                'list' => array(['href' => route('admin'), 'text'=> 'Beranda', 'is_active' => false ], ['href' => '', 'text' => 'All User', 'is_active' => true]),
                'title' => 'Show All User'
            ];
            @endphp
            @include('template.breadcrumb', $parsing)
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col">
            <h3> All User</h3>

            @if(session('notify'))
            <div class="alert alert-success my-2" role="alert">
                {{session('notify')}}
            </div>
             @endif
            <table class="table mb-2" id="tableUser">
                <thead>
                  <tr>
                    <th scope="col">Id User</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Address</th>
                    <th scope="col">Phone Number</th>
                    <th scope="col">Role</th>
                    <th scope="col">Act</th>
                  </tr>
                </thead>
                <tbody>
                @foreach($user as $usr)
                    @if($usr->role == "user")
                  <tr>
                    <th scope="row">{{$usr->id_user}}</th>
                    <td>{{$usr->name}}</td>
                    <td>{{$usr->email}}</td>
                    <td>{{$usr->address}}</td>
                    <td>{{$usr->phone_number}}</td>
                    <td>{{$usr->role}}</td>
                    <td>
                        <a href="{{$usr->id_user}}/#ComfirmDeleteUserModal" class="btn btn-danger" data-toggle="modal" data-target="#ComfirmDeleteUserModal{{$usr->id_user}}">Delete</a>
                    </td>
                  </tr>
                  @endif
                  @endforeach

                </tbody>
              </table>
        </div>
    </div>
</div>

@foreach($user as $usr)
 <div class="modal fade" id="ComfirmDeleteUserModal{{$usr->id_user}}" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Warning</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form action="/userdelete/{{$usr->id_user}}" method="POST">
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
