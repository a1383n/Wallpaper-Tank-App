<!doctype html>
<html lang="en">
@include('admin.include.head')
<body>
<div class="d-flex" id="wrapper">
    <!-- Sidebar -->
    <div class="bg-dark border-dark" id="sidebar-wrapper">
        <div class="sidebar-heading bg-dark text-light">Start Bootstrap</div>
        <div class="list-group list-group-flush">
            <a href="{{route('admin_home')}}" class="list-group-item list-group-item-action bg-dark text-light">
                <li class="fa fa-dashboard"></li>&nbsp;Dashboard</a>
            <a href="{{route('admin_wallpapers')}}" class="list-group-item list-group-item-action bg-dark text-light">
                <li class="fa fa-picture-o"></li>&nbsp;Wallpaper</a>
            <a href="index.php?a=category" class="list-group-item list-group-item-action bg-dark text-light">
                <li class="fa fa-tags"></li>&nbsp;Category</a>
        </div>
    </div>
    <!-- /#sidebar-wrapper -->

    <!-- Page Content -->
    <div id="page-content-wrapper">

        <nav class="navbar navbar-expand-lg navbar-dark bg-dark border-bottom">
            <button class="btn btn-primary" id="menu-toggle">
                <li class="fa fa-align-justify"></li>
            </button>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="../index.php">Home Site<span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="#">Edit Profile</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">Sing out</a>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
        <div class="container content-box">
            @yield('content')
        </div>
    </div>
</div>
<script src="{{asset('js/app.js')}}"></script>
<script src="{{asset('plugins/dataTables/jquery.dataTables.js')}}"></script>
<script src="{{asset('plugins/select2/select2.js')}}"></script>
<script src="{{asset('js/admin.js')}}"></script>
<!-- Menu Toggle Script -->
<script>
    $("#menu-toggle").click(function (e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");

        if (document.getElementsByClassName("content-box")[0].style.marginTop == "20px") {
            document.getElementsByClassName("content-box")[0].style.marginTop = "0"
            document.getElementsByClassName("content-box")[0].style.marginBottom = "0"
        } else {
            document.getElementsByClassName("content-box")[0].style.marginTop = "20px"
            document.getElementsByClassName("content-box")[0].style.marginBottom = "20px"
        }
    });
</script>
</body>
</html>
