<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <link rel="icon" href="/template_bootstrap/images/favicon.jpg" type="image/gif" />
    <link rel="stylesheet" href="/template_bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="/template_bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="/template_bootstrap/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="/template_bootstrap/css/bootstrap-dataTables.css">
    <link rel="stylesheet" href="/template_bootstrap/datatable/datatables.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css">
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css"> --}}
    <script src="/template_bootstrap/js/jquery-3.6.0.min.js"></script>
    <script src="/template_bootstrap/js/jquery.dataTables.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>

</head>
<body>
        <nav class="navbar navbar-expand-lg navbar-light bg-white">
                <?php
                $cekrole = auth()->user()->role
                ?>
                @if($cekrole == "admin")
                <a href="{{('/admindashboard')}}">
                        <img src="/template_bootstrap/images/bacabuku.jpg" class="img-fluid" alt="icon baca buku" sizes="100px">
                </a>
                @elseif($cekrole == "user")
                <a href="{{('/userdashboard')}}">
                    <img src="/template_bootstrap/images/bacabuku.jpg" class="img-fluid" alt="icon baca buku" sizes="100px">
                </a>
                @endif
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                  <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                  <ul class="navbar-nav mr-auto">
                    <li class="nav-item ">
                    <a class="nav-link" href="{{('/book')}}">Books </a>
                    </li>

                    @if($cekrole == "user")
                    <?php
                    $set_iduser = auth()->user()->id_user;
                    ?>
                    <li class="nav-item ">
                        <a class="nav-link" href="{{('/requestbook')}}">Request Book </a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link" href="/requestbook/info/{{$set_iduser}}">Your Request </a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link" href="/history">History Borrow </a>
                    </li>
                    @endif
                    @if($cekrole == "admin")
                    <li class="nav-item ">
                    <a class="nav-link" href="{{('/user')}}">Users </a>
                    </li>

                    <li class="nav-item">
                    <a class="nav-link" href="{{('/borrowedbook')}}">Book Out</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{('/reportborrowedbook')}}">Report Book Out</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{'/returnedbook'}}">Book In</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{('/requestedbook')}}">Request Book</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{('/reportrequestbook')}}" >Report Request</a>
                    </li>
                    @endif
                    <li class="nav-item">
                        <a class="nav-link" href="{{('/setting')}}">Setting</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="{{url('/logout')}}">Logout</a>
                    </li>
                  </ul>

                </div>
              </nav>

    @yield('container')


    <footer class="footer " style="
    position: fixed;
    left: 0;
    bottom: 0;
    width: 100%;
    background-color: #e3f2fd;
    color: black;
    text-align: center;">
        <div class="container mt-2">
            <div class="row justify-content-center">
             <p class="">Copyright  &copy; By Rangga Wisnu Aji {{date('Y')}} </p>
            </div>
        </div>
    </footer>



    <!-- Modal -->
     <div class="modal fade" id="ComingsoonModal" tabindex="-1">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Warning</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              Coming Soon
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>

      <script type="text/javascript">
            $(document).ready(function(){
                $('#tableBook').DataTable();
            })

            $(document).ready(function(){
                $('#tableUser').DataTable();
            })

            $(document).ready(function(){
                $('#tableHistoryRequest').DataTable();
            })

            $(document).ready(function(){
                $('#tableHistoryBorrow').DataTable();
            })

            $(document).ready(function() {
                $('#selectbook').DataTable();
            } );

            $(document).ready(function() {
                $('#selectuser').DataTable();
            } );
        $(document).on('click', '#pilihuser', function() {
			var iduser = $(this).data('idusrm');
			var nmuser = $(this).data('nmusrm');
			var phonenumber = $(this).data('phn_nmbrm');
			var role = $(this).data('rolem');
			$('#id_user').val(iduser);
			$('#name').val(nmuser);
			$('#phone_number').val(phonenumber);
			$('#role').val(role);
			$('#SelectUserModal').modal('hide');
        });

        $(document).on('click', '#pilihbuku', function() {
			var idbook = $(this).data('idbkm');
			var nmbook = $(this).data('nmbkm');
			var publisher = $(this).data('publism');
            var timerelease = $(this).data('tmrlsm');
            var pagesbook = $(this).data('pgsbkm');
            var stok = $(this).data('stkm');
			$('#id_book').val(idbook);
			$('#name_book').val(nmbook);
			$('#publisher').val(publisher);
            $('#pages_book').val(pagesbook);
            $('#stok').val(stok);
			$('#SelectBookModal').modal('hide');
		});
       </script>

    <script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js"></script>
    <script src="/template_bootstrap/js/dataTables.bootstrap4.min.js"></script>
    <script src="/template_bootstrap/js/bootstrap.js"></script>
    <script src="/template_bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
