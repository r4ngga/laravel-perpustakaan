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
    <script src="/template_bootstrap/js/jquery-3.6.0.min.js"></script>
</head>
<body>
        <nav class="navbar navbar-expand-lg navbar-light bg-white">
                <a href="{{('/')}}">
                  <img src="/template_bootstrap/images/bacabuku.jpg" class="img-fluid" alt="icon baca buku" sizes="100px">
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                  <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                  <ul class="navbar-nav mr-auto">
                    <li class="nav-item ">
                      <a class="nav-link" href="{{url('/home')}}" >Home </a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="{{url('/login')}}">Login</a>
                    </li>
                  </ul>

                </div>
              </nav>

    @yield('container')

    <footer class="footermt-4" style="
    position: fixed;
    left: 0;
    bottom: 0;
    width: 100%;
    background-color: #e3f2fd;
    color: black;
    text-align: center;">
        <div class="container mt-1">
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

    <script src="/template_bootstrap/js/bootstrap.js"></script>
    <script src="/template_bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
