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

            <a href="#" data-toggle="modal" data-target="#insert-user" class="btn btn-primary my-2"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-lg" viewBox="0 0 16 16">
                <path d="M8 0a1 1 0 0 1 1 1v6h6a1 1 0 1 1 0 2H9v6a1 1 0 1 1-2 0V9H1a1 1 0 0 1 0-2h6V1a1 1 0 0 1 1-1z"/>
              </svg> Insert a new user</a>

            @if(session('notify'))
            <div class="alert alert-success my-2" role="alert">
                {{session('notify')}}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="color: black">
                    <span aria-hidden="true">&times;</span>
                </button>
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
                @foreach($users as $usr)
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

@foreach($users as $usr)
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

<div class="modal fade" id="insert-user" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Insert a new user</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body m-2">
            <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('post')
                {{-- @method('delete') --}}
                {{-- <div class="form-group">
                            <label for="pages">Are you sure delete? Please Type "Delete" or "delete" </label>
                            <input type="text" class="form-control" id="validation" name="validation" placeholder="Type here">
                </div> --}}
                <div class="form-group">
                    <label for="name">Name</label> <span style="color: red;">*</span>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Type Name Here" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label> <span style="color: red;">*</span>
                    <input type="text" name="email" id="email" class="form-control" placeholder="Email Here" required>
                </div>
                <div class="form-group">
                    <label for="phonenumber">Phone Number</label> <span style="color: red;">*</span>
                    <input type="number" name="phone_number" id="phone_number" class="form-control" placeholder="Phone Number Here" required>
                </div>
                <div class="form-group">
                    <label for="adress">Address</label> <span style="color: red;">*</span>
                    <input type="text" name="address" id="address" class="form-control" placeholder="Type Address Here" required>
                </div>
                <div class="form-group">
                    <label for="gender">Gender</label> <span style="color: red;">*</span>
                    <div class="form-check">
                        <input type="radio" id="man" name="gender" value="man" class="form-check-input" required>
                        <label for="man">Man</label>
                      </div>
                      <div class="form-check">
                        <input type="radio" id="woman" name="gender" value="woman" class="form-check-input">
                        <label  for="woman">Woman</label>
                        {{-- @error('gender')
                        <div class="invalid-feedback">{{$message}}</div>
                        @enderror --}}
                      </div>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" class="form-control">
                </div>
                <div class="form-group">
                    <label for="label">Password dapat dikosongi apabila, tidak diubah</label>
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

@endsection()
