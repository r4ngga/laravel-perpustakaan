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

    .mini-img-photo{
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

            {{-- @if(session('notify'))
            <div class="alert alert-success my-2" role="alert" >
                {{session('notify')}}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="color: black">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
             @endif --}}

             <div id="ntf-success" class="alert alert-success my-3" role="alert" style="display: none">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="color: black">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
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
                <tbody id="row-table-user">
                @foreach($users as $usr)
                    {{-- @if($usr->role == 2) --}}
                  <tr>
                    <th scope="row">{{$usr->id_user}}</th>
                    <td>{{$usr->name}}</td>
                    <td>{{$usr->email}}</td>
                    {{-- <td>{{$usr->address}}</td> --}}
                    <td>{{$usr->phone_number}}</td>
                    {{-- <td>{{$usr->role}}</td> --}}
                    <td>
                        {{-- <button onclick="getEdit({{ $usr->id_user }}, '{{ $usr->name }}', '{{ $usr->email }}', '{{$usr->phone_number}}', '{{$usr->address}}', '{{ $usr->gender }}')" data-toggle="modal" data-target="#edit-user" class="btn btn-sm btn-info">Edit</button> --}}
                        <button onclick="fetchEdit({{ $usr->id_user ?? ''}})" data-toggle="modal" data-target="#edit-user" class="btn btn-sm btn-info">Edit</button>
                        <a href="#" onclick="confirmDeleteUser({{$usr->id_user ?? ''}})" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#ConfirmDeleteUser">Delete</a>
                        <button onclick="fetchShowUser({{ $usr->id_user }})" data-toggle="modal" data-target="#ShowUserModal" class="btn btn-sm btn-warning">Show</button>
                    </td>
                  </tr>
                  {{-- @endif --}}
                  @endforeach

                </tbody>
              </table>
        </div>
    </div>
</div>

{{-- @foreach($users as $usr) --}}
 <div class="modal fade" id="ConfirmDeleteUser" tabindex="-1">
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
            <form action="{{ route('users.store') }}" method="POST">
                @csrf
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
                        <input type="radio" id="man" name="add_gender" value="man" class="form-check-input" required>
                        <label for="man">Man</label>
                      </div>
                      <div class="form-check">
                        <input type="radio" id="woman" name="add_gender" value="woman" class="form-check-input">
                        <label  for="woman">Woman</label>                        
                      </div>
                </div>
                <div class="form-group">
                    <label for="password">Password</label> <span style="color: red;">*</span>
                    <input type="password" name="password" id="password" class="form-control">
                </div>
                <div class="form-group">
                    <label for="photoprofle">Photo Profile</label>
                    <input type="file" class="form-control" name="photo_profile" id="photo-profile">
                </div>
                <div class="form-group">
                    <label for="proflepgto">Photo Profile Dapat Dikosongi</label>
                </div>

                <button id="button-submit" type="submit"  class="btn btn-primary" >Confirm</button>
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
            {{-- <form action="{{ route('users.update') }}" method="POST" enctype="multipart/form-data"> --}}
            <form action="" method="" >
                {{-- @csrf --}}
                {{-- @method('post') --}}
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
                    <label for="placedatebirth">Place Date Of Birth</label>
                    <input type="text" class="form-control" name="" id="">
                </div>
                <div class="form-group">
                    <label for="gender">Gender</label> <span style="color: red;">*</span>
                    <div class="form-check">
                        <input type="radio" id="user-gender-man" name="gender" value="man" class="form-check-input" required>
                        <label for="man">Man</label>
                      </div>
                      <div class="form-check">
                        <input type="radio" id="user-gender-woman" name="gender" value="woman" class="form-check-input">
                        <label  for="woman">Woman</label>
                        {{-- @error('gender')
                        <div class="invalid-feedback">{{$message}}</div>
                        @enderror --}}
                      </div>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="user-password" class="form-control">
                </div>
                <div class="form-group">
                    <label for="label">Password dapat dikosongi apabila, tidak diubah</label>
                </div>
                <div class="form-group">
                    <label for="prfilepotho">Photo Profile</label>
                    <img src="" id="img-user" class="mini-img-photo" alt="" style="margin-top: 2px; margin-bottom: 4px;">
                    <input type="file" class="form-control mt-2" onchange="previewImage(event);" name="user_photo_profile" id="user-photo-profile">
                </div>
                <div class="form-group">
                    <label for="ketpp">Photo Profile dapat dikosongi apabila tidak dirubah</label>
                </div>
                <button id="btn-edt-usr" type="button" class="btn btn-primary">Confirm</button>
            </form>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
</div>

<div class="modal fade" id="ShowUserModal" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Detail User</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="container">
                <div class="row">
                    <div class="col">Id : </div>
                    <div class="col"> <p id="u-show-id"></p> </div>
                </div>
                <div class="row">
                    <div class="col">Name : </div>
                    <div class="col"> <p id="u-show-name"></p> </div>
                </div>
                <div class="row">
                    <div class="col">Address : </div>
                    <div class="col"> <p id="u-show-address"></p> </div>
                </div>
                <div class="row">
                    <div class="col">Phone Number : </div>
                    <div class="col"> <p id="u-show-pn"></p> </div>
                </div>
                <div class="row">
                    <div class="col">Email : </div>
                    <div class="col"> <p id="u-show-email"></p> </div>
                </div>
                <div class="row">
                    <div class="col">Role : </div>
                    <div class="col"> <p id="u-show-role"></p> </div>
                </div>
                <div class="row">
                    <div class="col">Gender : </div>
                    <div class="col"> <p id="u-show-gender"></p> </div>
                </div>
                <div class="row">
                    <div class="col">Created At : </div>
                    <div class="col"> <p id="u-show-creat"></p></div>
                </div>
                <div class="row" > <div class="col" style="justify-content: center; align-self: center"> Photo Profile User ; </div>
                <div class="col"> <img id="u-img" class="mini-img-photo" src="" alt=""> </div>
                </div>
            </div>

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
          const imagePreviewElement = document.querySelector("#img-user");
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

    // $(document).ready(function() {
        $('#btn-edt-usr').click(function(event) {
            event.preventDefault();

            let usr_id =  $('#user-id').val();
            let usr_name = $('#user-name').val();
            let usr_email = $('#user-email').val();
            let usr_phon = $('#user-phone').val();
            let usr_addrs = $('#user-address').val();
            // let usr_gender = document.querySelector('input[name="gender"]:checked').value();
            let usr_gender = $('input[name="gender"]:checked').val();
            let usr_pass = $('#user-password').val();
            console.log(usr_id, usr_addrs, usr_email, usr_name, usr_phon);
            $.ajax({
                type: 'POST',
                url: '/users/update/' + usr_id,
                data: {
                    _token:"{{ csrf_token() }}",
                    id_user:usr_id,
                    name:usr_name,
                    email:usr_email,
                    phone_number:usr_phon,
                    address:usr_addrs,
                    gender:usr_gender,
                    password:usr_pass
                },
                success: function(dt){
                    // console.log(dt);
                    $('#edit-user').modal('hide');
                    $('#ntf-success').css("display", "block");
                    $("#ntf-success").append(dt.data);
                    fetchusers();
                }
            });
        });
    // });

    function fetchusers()
    {
        $.ajax({
            type: 'GET',
            url: '{{ route('users.fetch-index') }}',
            success:function(data){
                // console.log(data);
                $('#row-table-user').html(data.html);
            }
        });
    }

    function fetchEdit(id){
        $.ajax({
            type: 'GET',
            url: '/fetchedit-user/' + id,
            processdata: false,
            success:function(data){
                console.log();
                document.getElementById('user-id').value = data.user_id;
                document.getElementById('user-name').value = data.name;
                document.getElementById('user-email').value = data.email;
                document.getElementById('user-address').value = data.address;
                document.getElementById('user-phone').value = data.phone_number;
                if(data.gender == 'man'){
                    document.getElementById('user-gender-man').checked = true;
                }else{
                    document.getElementById('user-gender-woman').checked = true;
                }

                document.getElementById('img-user').src = data.photo_profile;
                document.getElementById('user-placedatebirth').value = data.place_date_birth;
            }
        });
    }

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
                        btn_set.disabled = true;
                    }else{
                        btn_set.disabled = false;
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
                        btn_set.disabled = true;
                    }else{
                        btn_set.disabled = false;
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
          document.getElementById('user-gender-man').checked = true;
        }else{
          document.getElementById('user-gender-woman').checked = true;
        }
        /* show data to modal */
    }

    function setDeleteUser(id){
        let user_id = id;
        console.log(user_id);
        document.getElementById('u-userid').value = user_id;
    }

    function fetchShowUser(id){
        $.ajax({
            type: 'GET',
            url: 'users/'+id,
            processdata: false,
            success:function(data){
                // console.log(data);
                document.getElementById('u-show-id').innerHTML = data.id;
                document.getElementById('u-show-name').innerHTML = data.name;
                document.getElementById('u-show-address').innerHTML = data.address;
                document.getElementById('u-show-pn').innerHTML = data.phone_number;
                document.getElementById('u-show-email').innerHTML = data.email;
                document.getElementById('u-show-role').innerHTML = data.role;
                // if()
                document.getElementById('u-show-gender').innerHTML = data.gender;
                document.getElementById('u-show-creat').innerHTML = data.created_at;
                document.getElementById('u-img').src = data.photo_profile;
                if(!data.photo_profile )
                {
                    document.getElementById('u-img').src =  '/photo_profile/profile-default.png';
                }else{
                document.getElementById('u-img').src =  '/photo_profile/'+data.photo_profile;
            }
            }
        });
    }

    function confirmDeleteUser(id)
    {
        const usrid = id;
        document.getElementById('u-userid').value = usrid;
    }

</script>
@endsection
