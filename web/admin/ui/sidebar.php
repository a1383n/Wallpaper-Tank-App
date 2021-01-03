<?php (!$isLogin) ? header("Location: ../login.php") : null?>
<div class="d-flex" id="wrapper">
    <!-- Sidebar -->
    <div class="bg-dark border-dark" id="sidebar-wrapper">
        <div class="sidebar-heading bg-dark text-light">Start Bootstrap</div>
        <div class="list-group list-group-flush">
            <a href="index.php" class="list-group-item list-group-item-action bg-dark text-light">
                <li class="fa fa-dashboard"></li>&nbsp;Dashboard</a>
            <a href="index.php?a=wallpaper" class="list-group-item list-group-item-action bg-dark text-light">
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
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <?php echo $_SESSION['name']; ?>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="#">Edit Profile</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">Sing out</a>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
        <!-- /#page-content-wrapper -->