@extends('template/maindashboard')

@section('title','Show all user')
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

            <div class="row mb-4">
                <div class="col col-lg-6">
                    <a href="#" data-toggle="modal" data-target="#insert-user" class="btn btn-primary my-2"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-lg" viewBox="0 0 16 16">
                        <path d="M8 0a1 1 0 0 1 1 1v6h6a1 1 0 1 1 0 2H9v6a1 1 0 1 1-2 0V9H1a1 1 0 0 1 0-2h6V1a1 1 0 0 1 1-1z"/>
                      </svg> Insert a new user</a>
                </div>
                <div class="col col-lg-6 pt-1">
                    <div class="card card-total">
                        <h5>Total Users {{ $countUser ?? 0 }}</h5>
                    </div>
                </div>
            </div>

            @if(session('notify'))
            <div class="alert alert-success my-2" role="alert">
                {{session('notify')}}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="color: black">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
             @endif
            <table class="table table-bordered border-1 mb-2" id="tableUser">
                <thead>
                  <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    {{-- <th scope="col">Address</th> --}}
                    <th scope="col">Phone Number</th>
                    {{-- <th scope="col">Role</th> --}}
                    <th scope="col" style="text-align: center">Act</th>
                  </tr>
                </thead>
                <tbody>
                @foreach($users as $usr)
                    @if($usr->role == 2)
                  <tr>
                    <th scope="row">{{$usr->id_user}}</th>
                    <td>{{$usr->name}}</td>
                    <td>{{$usr->email}}</td>
                    {{-- <td>{{$usr->address}}</td> --}}
                    <td>{{$usr->phone_number}}</td>
                    {{-- <td>{{$usr->role}}</td> --}}
                    <td>
                        <button onclick="getEdit({{ $usr->id_user }}, '{{ $usr->name }}', '{{ $usr->email }}', '{{$usr->phone_number}}', '{{$usr->address}}', '{{ $usr->gender }}')" data-toggle="modal" data-target="#edit-user" class="btn btn-sm btn-info">Edit</button>
                        <a href="{{$usr->id_user}}/#ComfirmDeleteUserModal" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#ComfirmDeleteUserModal{{$usr->id_user}}">Delete</a>
                        <a href="" data-toggle="modal" data-target="" class="btn btn-sm btn-warning">Show</a>
                    </td>
                  </tr>
                  @endif
                  @endforeach

                </tbody>
              </table>
        </div>
    </div>
</div>

{{-- @foreach($users as $usr) --}}
 <div class="modal fade" id="ComfirmDeleteUserModal" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Warning</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form action="{{ route('users.delete') }}" method="POST">
                @csrf
                {{-- @method('delete') --}}
                    <div class="form-group">
                        <input type="hidden" name="id_user" id="u-userid">
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
                    <input type="text" name="email" id="add-email" class="form-control" placeholder="Email Here" required>
                    <span id="msg-email" class="text-sm text-gray-600 one-number" style="display: none;">
                        <i class="fas fa-circle" aria-hidden="true"></i>
                        &nbsp;<p id="response-email"></p>
                    </span>
                </div>
                <div class="form-group">
                    <label for="phonenumber">Phone Number</label> <span style="color: red;">*</span>
                    <input type="number" name="phone_number" id="add_phone_number" class="form-control" placeholder="Phone Number Here" required>
                    <span id="msg-phone" class="text-sm text-gray-600 one-number" style="display: none;">
                        <i class="fas fa-circle" aria-hidden="true"></i>
                        &nbsp;<p id="response-phone"></p>
                    </span>
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
                <button id="button-submit" type="submit"  class="btn btn-primary" disabled>Confirm</button>
            </form>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
</div>

<div class="modal fade" id="edit-user" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Edit a user</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body m-2">
            <form action="{{ route('users.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('post')
                {{-- @method('delete') --}}
                {{-- <div class="form-group">
                            <label for="pages">Are you sure delete? Please Type "Delete" or "delete" </label>
                            <input type="text" class="form-control" id="validation" name="validation" placeholder="Type here">
                </div> --}}
                <input type="hidden" name="id_user" id="user-id" value="">
                <div class="form-group">
                    <label for="name">Name</label> <span style="color: red;">*</span>
                    <input type="text" class="form-control" id="user-name" name="name" value="" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label> <span style="color: red;">*</span>
                    <input type="text" name="email" id="user-email" class="form-control" value="" required>
                </div>
                <div class="form-group">
                    <label for="phonenumber">Phone Number</label> <span style="color: red;">*</span>
                    <input type="number" name="phone_number" id="user-phone" class="form-control" value="" required>
                </div>
                <div class="form-group">
                    <label for="adress">Address</label> <span style="color: red;">*</span>
                    <input type="text" name="address" id="user-address" class="form-control" value="" required>
                </div>
                <div class="form-group">
                    <label for="gender">Gender</label> <span style="color: red;">*</span>
                    <div class="form-check">
                        <input type="radio" id="usr-man" name="gender" value="man" class="form-check-input" required>
                        <label for="man">Man</label>
                      </div>
                      <div class="form-check">
                        <input type="radio" id="usr-woman" name="gender" value="woman" class="form-check-input">
                        <label  for="woman">Woman</label>
                        {{-- @error('gender')
                        <div class="invalid-feedback">{{$message}}</div>
                        @enderror --}}
                      </div>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="usr-password" class="form-control">
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

@section('scripts')
<script>
    $(document).ready(function(){
        let msg_email_valid =  document.getElementById('msg-email').textContent;
        let msg_phone_valid = document.getElementById('msg-phone').textContent;

        let btn_set = document.getElementById('button-submit');
        if(msg_email_valid == 'valid' && msg_phone_valid == 'valid'){
            btn_set.disabled = false;
        }
    });

    const getPhoneNumber = document.querySelector("#add_phone_number");
    const getEmail = document.querySelector("#add-email");
    let btn_set = document.getElementById('button-submit');

    getEmail.addEventListener("blur", (event) => {
        event.preventDefault();

        const emai = getEmail.value;
        console.log(emai);
        let msg_email_valid =  document.getElementById('msg-email').textContent;
        let msg_phone_valid = document.getElementById('msg-phone').textContent;
        $.ajax({
            type: 'POST',
            data: {email:emai, _token:"{{ csrf_token() }}"},
            url: "{{ route('validation-email') }}",
            success: function(e){
                console.log(e);
                if(e.status == true){
                    document.getElementById('msg-email').style.display = 'block';
                    document.getElementById('msg-email').style.color = '#02b502';
                    const responseMessage = document.getElementById('msg-email');
                    responseMessage.textContent = e.message;
                    if(msg_email_valid == 'valid' && msg_phone_valid == 'valid'){
                        btn_set.disabled = false;
                    }else{
                        btn_set.disabled = true;
                    }

                }else{
                    document.getElementById('msg-email').style.display = 'block';
                    document.getElementById('msg-email').style.color = '#e90f10';
                    const responseMessage = document.getElementById('msg-email');
                    responseMessage.textContent = e.message;
                }
            }
        });
    });


    getPhoneNumber.addEventListener("blur", (event) => {
        event.preventDefault();

        const phone_number = getPhoneNumber.value;
        console.log(phone_number);
        let email_valid =  document.getElementById('msg-email').textContent;
        let phone_valid = document.getElementById('msg-phone').textContent;

        $.ajax({
            type: 'POST',
            data: {phone_number:phone_number, _token:"{{ csrf_token() }}"},
            url: "{{ route('validation-phone') }}",
            success: function(e){
                console.log(e);
                if(e.status == true){
                    document.getElementById('msg-phone').style.display = 'block';
                    document.getElementById('msg-phone').style.color = '#02b502';
                    const responseMessage = document.getElementById('msg-phone');
                    responseMessage.textContent = e.message;

                    if(email_valid == 'valid' && phone_valid == 'valid'){
                        btn_set.disabled = false;
                    }else{
                        btn_set.disabled = true;
                    }
                }else{
                    document.getElementById('msg-phone').style.display = 'block';
                    document.getElementById('msg-phone').style.color = '#e90f10';
                    const responseMessage = document.getElementById('msg-phone');
                    responseMessage.textContent = e.message;
                }
            }
        });
    });

    function getEdit(id, nm, eml, pn, adres, gnder){
        let user_id = id;
        let user_name = nm;
        let user_email = eml;
        let user_phone = pn;
        let user_address = adres;
        let user_gender = gnder;
        console.log(user_id, user_name, user_email, user_phone, user_address, user_gender);
        document.getElementById('user-id').value = user_id;
        document.getElementById('user-name').value = user_name;
        document.getElementById('user-email').value = user_email;
        document.getElementById('user-phone').value = user_phone;
        document.getElementById('user-address').value = user_address;
        if(user_gender == 'man'){
          document.getElementById('usr-man').checked = true;
        }else{
          document.getElementById('usr-woman').checked = true;
        }
        /* show data to modal */
    }

    function setDeleteUser(id){
        let user_id = id;
        console.log(user_id);
        document.getElementById('u-userid').value = user_id;
    }

    function fetchShowUser(id){

        // $.ajax({});
    }
</script>
@endsection
