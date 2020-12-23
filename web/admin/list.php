<?php
session_start();
if (!isset($_SESSION['isLogin']) || $_SESSION['isLogin'] != true) {
    header("Location: index.php");
    exit();
}
include "inc/PanelHelper.php";
$helper = new PanelHelper();
/**
 * Get either a Gravatar URL or complete image tag for a specified email address.
 *
 * @param string $email The email address
 * @param string $s Size in pixels, defaults to 80px [ 1 - 2048 ]
 * @param string $d Default imageset to use [ 404 | mp | identicon | monsterid | wavatar ]
 * @param string $r Maximum rating (inclusive) [ g | pg | r | x ]
 * @param boole $img True to return a complete IMG tag False for just the URL
 * @param array $atts Optional, additional key/value attributes to include in the IMG tag
 * @return String containing either just a URL or a complete image tag
 * @source https://gravatar.com/site/implement/images/php/
 */
function get_gravatar($email, $s = 80, $d = 'mp', $r = 'g', $img = false, $atts = array())
{
    $url = 'https://www.gravatar.com/avatar/';
    $url .= md5(strtolower(trim($email)));
    $url .= "?s=$s&d=$d&r=$r";
    if ($img) {
        $url = '<img src="' . $url . '"';
        foreach ($atts as $key => $val)
            $url .= ' ' . $key . '="' . $val . '"';
        $url .= ' />';
    }
    return $url;
}

?>
<?php if (isset($_GET['t']) && $_GET['t'] == 'wallpaper'): ?>
    <html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
        <!-- Ionicons -->
        <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="../assets/css/adminlte.min.css">
        <!-- DataTable Bootstrap -->
        <link rel="stylesheet" href="../assets/plugins/datatables/dataTables.bootstrap4.css">
        <!-- Google Font: Source Sans Pro -->
        <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
        <!-- bootstrap rtl -->
        <link rel="stylesheet" href="../assets/css/bootstrap-rtl.min.css">
        <!-- template rtl version -->
        <link rel="stylesheet" href="../assets/css/custom-style.css">
        <!-- Select Library -->
        <link rel="stylesheet" href="../assets/plugins/select2/select2.css">
        <title>نمایش داده ها | پس زمینه ها</title>

    </head>
    <body class="hold-transition sidebar-mini sidebar-collapse">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand bg-white navbar-light border-bottom">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#"><i class="fa fa-bars"></i></a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="panel.php" class="nav-link">خانه</a>
            </li>
        </ul>
    </nav>
    <!-- /.navbar -->
    <div class="wrapper">
        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary sidebar-collapse elevation-5">
            <!-- Brand Logo -->
            <a href="#" class="brand-link">
                <span class="brand-text font-weight-light">پنل مدیریت</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <div>
                    <!-- Sidebar user panel (optional) -->
                    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                        <div class="image">
                            <img src="<?php echo get_gravatar($_SESSION['email']) ?>" class="img-circle elevation-2"
                                 alt="User Image">
                        </div>
                        <div class="info">
                            <a href="#" class="d-block"><?php echo $_SESSION['name'] ?></a>
                        </div>
                    </div>
                    <!-- Sidebar Menu -->
                    <nav class="mt-2">
                        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                            data-accordion="false">
                            <li class="nav-item">
                                <a href="panel.php" class="nav-link">
                                    <i class="nav-icon fa fa-dashboard"></i>
                                    <p>
                                        داشبورد
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item has-treeview menu-open">
                                <a href="#" class="nav-link active">
                                    <i class="nav-icon fa fa-list"></i>
                                    <p>
                                        نمایش داده ها
                                        <i class="right fa fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="list.php?t=wallpaper" class="nav-link active">
                                            <i class="fa fa-picture-o nav-icon"></i>
                                            <p>پس زمینه ها</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="list.php?t=category" class="nav-link">
                                            <i class="fa fa-tag nav-icon"></i>
                                            <p>موضوعات</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="list.php?t=user" class="nav-link">
                                            <i class="fa fa-user nav-icon"></i>
                                            <p>کاربران</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </nav>
                    <!-- /.sidebar-menu -->
                </div>
            </div>
            <!-- /.sidebar -->
        </aside>
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0 text-dark">نمایش داده ها</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-left">
                                <li class="breadcrumb-item">خانه</li>
                                <li class="breadcrumb-item">نمایش داده ها</li>
                                <li class="breadcrumb-item active">پس زمینه ها</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->
            <?php
            $db = new DB();
            $result = $db->Select("wallpapers");
            ?>
            <!-- Main content -->
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="modal fade" id="showAdd" tabindex="-1" aria-labelledby="showAdd"
                                 aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="showAdd">افزودن</h5>
                                            <button type="button" class="close" style="margin-left: 0;"
                                                    data-dismiss="modal"
                                                    aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form role="form">
                                                <div class="form-group">
                                                    <label for="add-title">عنوان</label>
                                                    <input type="text" class="form-control" id="add-title">
                                                </div>
                                                <div class="form-group">
                                                    <label for="add-dis">توضیحات</label>
                                                    <textarea type="text" class="form-control" id="add-dis"></textarea>
                                                </div>
                                                <label>انتخاب پس زمینه</label>
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" accept="image/jpeg"
                                                           id="imageFile">
                                                    <label class="custom-file-label" for="imageFile">انتخاب عکس</label>
                                                </div>
                                                <br>
                                                <div class="form-group">
                                                    <label>موضوع</label>
                                                    <select class="form-control select2" style="width: 100%;"
                                                            id="add-category-2">
                                                        <?php
                                                        $category = $db->Select("category");
                                                        ?>
                                                        <?php while ($row = mysqli_fetch_assoc($category)): ?>
                                                            <option value="<?php echo $row['name'];?>"><?php echo $row['title']; ?></option>
                                                        <?php endwhile; ?>
                                                    </select>
                                                </div>
                                                <label>افزودن برچسب</label>
                                                <div class="form-inline">
                                                    <input type="text" class="form-control" style="width: 75%" id="add-tag-input-2">
                                                    <button type="button" class="btn btn-danger" style="width: 25%"
                                                            id="add-tag-btn-2" onclick="addTagForNew()">
                                                        افزودن
                                                    </button>
                                                </div>
                                                <div class="form-group" id="add-tags">
                                                    <label>برچسب ها</label><br>

                                                </div>
                                                <div class="form-group">
                                                    <div class="progress">
                                                        <div class="progress-bar progress-bar-striped progress-bar-animated" id="add-progress" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;display: none;"></div>
                                                    </div>
                                                </div>
                                                <input type="hidden" id="tag-string-2">
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" style="margin-left: 15px;"
                                                    data-dismiss="modal" onclick="location.reload()">بستن
                                            </button>
                                            <button type="button" class="btn btn-primary" id="add-submite">ذخیره
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal -->
                            <div class="modal fade" id="showImage" tabindex="-1" aria-labelledby="showImage"
                                 aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="showImage">نمایش تصویر</h5>
                                            <button type="button" class="close" style="margin-left: 0;"
                                                    data-dismiss="modal"
                                                    aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body" id="model-body">

                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">بستن
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade" id="showEdit" tabindex="-1" aria-labelledby="showEdit"
                                 aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="showEdit">ویرایش</h5>
                                            <button type="button" class="close" style="margin-left: 0;"
                                                    data-dismiss="modal"
                                                    aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form role="form">
                                                <input name="id" type="hidden" value="" id="edit-id">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">عنوان</span>
                                                    </div>
                                                    <input type="text" class="form-control" id="edit-title">
                                                </div>
                                                <br>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">توضیحات</span>
                                                    </div>
                                                    <textarea type="text" class="form-control" id="edit-dis"></textarea>
                                                </div>
                                                <br>
                                                <div class="form-group">
                                                    <label>موضوع</label>
                                                    <select class="form-control select2" style="width: 100%;"
                                                            id="edit-category">
                                                        <option selected="selected" id="category-selected"></option>
                                                        <?php
                                                        $category = $db->Select("category");
                                                        ?>
                                                        <?php while ($row = mysqli_fetch_assoc($category)): ?>
                                                            <option><?php echo $row['title']; ?></option>
                                                        <?php endwhile; ?>
                                                    </select>
                                                </div>
                                                <div class="form-group ltr">
                                                    <label>افزودن برچسب</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <button type="button" class="btn btn-danger"
                                                                    id="add-tag-btn">
                                                                افزودن
                                                            </button>
                                                        </div>
                                                        <input type="text" class="form-control" id="add-tag-input"
                                                               style="direction: rtl;">
                                                    </div>
                                                </div>
                                                <div class="form-group" id="edit-tags">
                                                    <label>برچسب ها</label><br>
                                                </div>
                                                <input type="hidden" id="tag-string">
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" style="margin-left: 15px;"
                                                    data-dismiss="modal" onclick="location.reload()">بستن
                                            </button>
                                            <button type="button" class="btn btn-primary" onclick="submitEdit()">ذخیره
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Modal -->
                            <div class="modal fade" id="deleteItem" tabindex="-1" aria-labelledby="deleteItem"
                                 aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content" style="width: 60%;margin: 0 auto;">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="deleteItem">حذف</h5>
                                        </div>
                                        <div class="modal-body">
                                            <input type="hidden" id="delete-id">
                                            <p>آیا از حدف این ردیف اطمینان دارید؟</p>
                                            <button class="btn btn-secondary" data-dismiss="modal">بستن</button>
                                            <button class="btn btn-danger" id="confirmDelete">حذف</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title" style="display: inline">لیست پس زمینه ها</h3>
                                    <button class="btn btn-primary float-left" style="display: inline"
                                            onclick="showAddModal()"> افزودن پس زمینه جدید
                                    </button>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <table id="wallpaper-table"
                                           class="table table-responsive table-striped text-center">
                                        <thead>
                                        <tr>
                                            <th>ردیف</th>
                                            <th>تیتر</th>
                                            <th>توضیحات</th>
                                            <th>موضوع</th>
                                            <th>برچسب ها</th>
                                            <th>لایک</th>
                                            <th>بازدید</th>
                                            <th>دانلود</th>
                                            <th>عملیات</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php while ($row = mysqli_fetch_assoc($result)): ?>
                                            <tr>
                                                <td><?php echo $helper->fa_number($row['id']); ?></td>
                                                <td><?php echo $row['title']; ?></td>
                                                <td><?php echo $row['dis']; ?></td>
                                                <td><?php echo $row['category']; ?></td>
                                                <td><?php echo $row['tags']; ?></td>
                                                <td><?php echo $helper->fa_number($row['likes']); ?></td>
                                                <td><?php echo $helper->fa_number($row['views']); ?></td>
                                                <td><?php echo $helper->fa_number($row['downloads']); ?></td>
                                                <td>
                                                    <div class="btn-group" role="group">
                                                        <button class="btn btn-primary"
                                                                onclick="showImage('<?php echo $row['wallpaper']; ?>')">
                                                            مشاهده
                                                        </button>
                                                        <button class="btn btn-secondary"
                                                                onclick="showEditModal(<?php echo $row['id']; ?>)">
                                                            ویرایش
                                                        </button>
                                                        <button class="btn btn-danger"
                                                                onclick="showDeleteModal(<?php echo $row['id'] ?>)">حذف
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endwhile; ?>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.card-body -->
                            </div>
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->
    <script src="../assets/js/jquery-3.5.1.min.js"></script>
    <script src="../assets/js/bootstrap.js"></script>
    <script src="../assets/js/bootstrap.bundle.js"></script>
    <script src="../assets/plugins/datatables/jquery.dataTables.js"></script>
    <script src="../assets/plugins/datatables/dataTables.bootstrap4.js"></script>
    <script src="../assets/plugins/select2/select2.min.js"></script>
    <script src="../assets/js/adminlte.min.js"></script>
    <script src="../assets/plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <script src="../assets/plugins/fastclick/fastclick.min.js"></script>
    <script src="../assets/js/pages/wallpaper_list_script.js"></script>

    </body>
<?php elseif (isset($_GET['t']) && $_GET['t'] == 'category'): ?>
    <html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../assets/css/adminlte.min.css">
    <!-- DataTable Bootstrap -->
    <link rel="stylesheet" href="../assets/plugins/datatables/dataTables.bootstrap4.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <!-- bootstrap rtl -->
    <link rel="stylesheet" href="../assets/css/bootstrap-rtl.min.css">
    <!-- template rtl version -->
    <link rel="stylesheet" href="../assets/css/custom-style.css">
    <!-- Select Library -->
    <link rel="stylesheet" href="../assets/plugins/select2/select2.css">
    <title>نمایش داده ها | موضوع ها</title>

</head>
<body class="hold-transition sidebar-mini sidebar-collapse">
<!-- Navbar -->
<nav class="main-header navbar navbar-expand bg-white navbar-light border-bottom">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#"><i class="fa fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="panel.php" class="nav-link">خانه</a>
        </li>
    </ul>
</nav>
<!-- /.navbar -->
<div class="wrapper">
    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary sidebar-collapse elevation-5">
        <!-- Brand Logo -->
        <a href="#" class="brand-link">
            <span class="brand-text font-weight-light">پنل مدیریت</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            <div>
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="<?php echo get_gravatar($_SESSION['email']) ?>" class="img-circle elevation-2"
                             alt="User Image">
                    </div>
                    <div class="info">
                        <a href="#" class="d-block"><?php echo $_SESSION['name'] ?></a>
                    </div>
                </div>
                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <li class="nav-item">
                            <a href="panel.php" class="nav-link">
                                <i class="nav-icon fa fa-dashboard"></i>
                                <p>
                                    داشبورد
                                </p>
                            </a>
                        </li>
                        <li class="nav-item has-treeview menu-open">
                            <a href="#" class="nav-link active">
                                <i class="nav-icon fa fa-list"></i>
                                <p>
                                    نمایش داده ها
                                    <i class="right fa fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="list.php?t=wallpaper" class="nav-link">
                                        <i class="fa fa-picture-o nav-icon"></i>
                                        <p>پس زمینه ها</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="list.php?t=category" class="nav-link active">
                                        <i class="fa fa-tag nav-icon"></i>
                                        <p>موضوعات</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="list.php?t=user" class="nav-link">
                                        <i class="fa fa-user nav-icon"></i>
                                        <p>کاربران</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
        </div>
        <!-- /.sidebar -->
    </aside>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">نمایش داده ها</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-left">
                            <li class="breadcrumb-item">خانه</li>
                            <li class="breadcrumb-item">نمایش داده ها</li>
                            <li class="breadcrumb-item active">پس زمینه ها</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->
        <?php
        $db = new DB();
        $result = $db->Select("category");
        ?>


        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <!-- Modal -->
                        <div class="modal fade" id="editCategory" tabindex="-1" aria-labelledby="editCategory"
                             aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">ویرایش</h5>
                                        <button type="button" class="close" style="margin-left: 0;" data-dismiss="modal"
                                                aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body" id="model-body">
                                        <form>
                                            <input type="hidden" value="id" id="edit-id">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">نام</span>
                                                </div>
                                                <input type="text" id="edit-name" class="form-control">
                                            </div>
                                            <br>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">عنوان</span>
                                                </div>
                                                <input type="text" id="edit-title" class="form-control">
                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-primary" id="save-edit"
                                                style="margin-left: 15px;">ذخیره
                                        </button>
                                        <br>
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">بستن
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="removeCategory" tabindex="-1" aria-labelledby="removeCategory"
                             aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content" style="width: 60%;margin: 0 auto;">
                                    <div class="modal-header">
                                        <h5 class="modal-title">حذف</h5>
                                        <button type="button" class="close" style="margin-left: 0;" data-dismiss="modal"
                                                aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body" id="model-body">
                                        <form>
                                            <input type="hidden" value="id" id="delete-id">
                                        </form>
                                        <p>آیا از حذف این ردیف اطمینان دارید؟</p>
                                        <button type="button" class="btn btn-danger" onclick="deleteCategory()"
                                                id="apply-delete" style="margin-left: 15px;">حذف
                                        </button>
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">بستن
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title" style="display: inline">لیست موضوع ها</h3>

                                <button class="btn btn-primary float-left" style="display: inline">افزودن موضوع جدید
                                </button>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="wallpaper-table" class="table table-responsive-md table-striped text-center">
                                    <thead>
                                    <tr>
                                        <th>ردیف</th>
                                        <th>نام موضوع</th>
                                        <th>عنوان</th>
                                        <th>تعداد پس زمینه ها</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                                        <tr>
                                            <td><?php echo $helper->fa_number($row['id']); ?></td>
                                            <td><?php echo $row['name']; ?></td>
                                            <td><?php echo $row['title']; ?></td>
                                            <td><?php echo $helper->fa_number($row['count']); ?></td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <button class="btn btn-secondary"
                                                            onclick="editCategory(<?php echo $row['id'] ?>)">ویرایش
                                                    </button>
                                                    <button class="btn btn-danger"
                                                            onclick="ShowdeleteCategory(<?php echo $row['id'] ?>)">حذف
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
<script src="../assets/js/jquery-3.5.1.min.js"></script>
<script src="../assets/js/bootstrap.js"></script>
<script src="../assets/js/bootstrap.bundle.js"></script>
<script src="../assets/plugins/datatables/jquery.dataTables.js"></script>
<script src="../assets/plugins/datatables/dataTables.bootstrap4.js"></script>
<script src="../assets/plugins/select2/select2.min.js"></script>
<script src="../assets/js/adminlte.min.js"></script>
<script src="../assets/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<script src="../assets/plugins/fastclick/fastclick.min.js"></script>
<script src="../assets/js/pages/category_list_script.js"></script>

</body>

<?php endif; ?>