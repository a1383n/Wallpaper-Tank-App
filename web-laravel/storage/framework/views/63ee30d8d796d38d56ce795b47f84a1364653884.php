<!doctype html>
<html lang="en">
<?php echo $__env->make('admin.include.head', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<body>
<div class="d-flex" id="wrapper">
    <!-- Sidebar -->
    <div class="bg-dark border-dark" id="sidebar-wrapper">
        <div class="sidebar-heading bg-dark text-light">AdminPanel</div>
        <div class="list-group list-group-flush">
            <a href="<?php echo e(route('admin_home')); ?>" class="list-group-item list-group-item-action bg-dark text-light">
                <li class="fa fa-dashboard"></li>&nbsp;Dashboard</a>
            <a href="<?php echo e(route('admin_wallpapers')); ?>" class="list-group-item list-group-item-action bg-dark text-light">
                <li class="fa fa-picture-o"></li>&nbsp;Wallpaper</a>
            <a href="<?php echo e(route('admin_categories')); ?>" class="list-group-item list-group-item-action bg-dark text-light">
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
                        <a class="nav-link" href="<?php echo e(route('index')); ?>">Home Site<span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <?php echo e(\App\Models\User::find(\Illuminate\Support\Facades\Auth::id())->name); ?>

                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <form method="post" action="<?php echo e(route('logout')); ?>">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="dropdown-item">Sing out</button>
                            </form>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo e(route('admin_home')); ?>">Panel</a></li>
                <li class="breadcrumb-item active" aria-current="page"><?php echo $__env->yieldContent('title'); ?></li>
            </ol>
        </nav>
        <div class="container content-box">
            <?php echo $__env->yieldContent('content'); ?>
        </div>
    </div>
</div>
<script src="<?php echo e(asset('js/app.js')); ?>"></script>
<script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.23/js/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo e(asset('plugins/select2/select2.js')); ?>"></script>
<script src="<?php echo e(asset('js/admin.js')); ?>"></script>
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
<?php /**PATH C:\Users\AmirSobhan_LP\Documents\GitHub\Wallpaper-Tank-App\web-laravel\resources\views/admin/layout.blade.php ENDPATH**/ ?>