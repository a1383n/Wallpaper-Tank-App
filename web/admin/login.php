<?php
session_start();
if (isset($_SESSION['isLogin']) && $_SESSION['isLogin'] == true){
    header("Location: index.php");
    exit();
}
include "inc/DB.php";
$login_successful = '
               <div class="alert alert-success">
                    <h5><i class="icon fa fa-check-circle"></i>&nbsp;<span id="">موفق!</span></h5>
                    <span>با موفقیت وارد شدید</span><br>
                    <span>در حال انتقال به پنل مدیریت ...</span><br><span><a href="panel.php">ورود به پنل مدیریت</a></span>
                </div>
';
$login_failure = '
               <div class="alert alert-danger">
                    <h5><i class="icon fa fa-ban"></i>&nbsp;<span id="">خطا!</span></h5>
                    <span>نام کاربری یا کلمه عبور اشتباه است</span><br>
                </div>
';
?>
<!doctype html>
<html lang="en">
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
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <!-- bootstrap rtl -->
    <link rel="stylesheet" href="../assets/css/bootstrap-rtl.min.css">
    <!-- template rtl version -->
    <link rel="stylesheet" href="../assets/css/custom-style.css">
    <title>ورود</title>
    <script src="../assets/js/jquery-3.5.1.min.js"></script>
    <style>
        body {
            background: #333333;
        }

        .container, .col-md-4 {
            margin-top: 50px;
        }

        .card-footer {
            text-align-last: center;
        }

        .btn, .btn-dark {
            width: 30%;
        }

        #notification {
            display: none;
        }
    </style>
</head>
<body>
<div class="container col-md-4">
    <div class="card card-dark">
        <div class="card-header text-center">
            <h3 class="card-title">ورود</h3>
        </div>
        <form role="form" method="post" action="login.php">
            <div class="card-body">
                <?php
                if (isset($_POST['submit'])) {
                    if (isset($_POST['username']) && isset($_POST['password'])) {
                        $db = new DB();
                        $result = $db->Select("users");
                        while ($row = mysqli_fetch_assoc($result)) {
                            if ($row['username'] == $_POST['username'] && password_verify($_POST['password'], $row['password'])) {
                                echo $login_successful;
                                $_SESSION['isLogin'] = true;
                                $_SESSION['name'] = $row['name'];
                                $_SESSION['username'] = $row['username'];
                                $_SESSION['email'] = $row['email'];
                                echo '
                                    <script>
                                    $(document).ready(function() {
                                       $("div .form-group,div .form-check,div .card-footer").hide();
                                    });
                                    async function as(){
                                        await new Promise(resolve => setTimeout(resolve, 2000));
                                        window.location = "index.php";
                                    }
                                    as();
                                    </script>
                                ';
                            } else {
                                echo $login_failure;
                            }
                        }
                    }
                }
                ?>
                <div class="alert alert-warning" id="notification">
                    <h5><i class="icon fa fa-warning"></i>&nbsp;<span id="notification-title">توجه!</span></h5>
                    <span id="notification-body"></span>
                </div>
                <div class="form-group">
                    <label for="Inputusername">نام کاربری</label>
                    <input type="text" name="username" class="form-control" id="Inputusername"
                           placeholder="نام کاربری را وارد کنید">
                </div>
                <div class="form-group">
                    <label for="InputPassword">کلمه عبور</label>
                    <input type="password" class="form-control" id="InputPassword" name="password"
                           placeholder="کلمه عبور را وارد کنید">
                </div>
                <div class="form-check">
                    <input type="checkbox" name="remember_me" class="form-check-input" id="Checkremember">
                    <label class="form-check-label" for="Checkremember">مرا بخاطر بسپار</label>
                </div>
            </div>
            <div class="card-footer" style="text-align-last: center;">
                <button type="submit" name="submit" class="btn btn-dark">ورود</button>
            </div>
        </form>
    </div>
</div>
<script src="../assets/js/bootstrap.min.js"></script>
<script src="../assets/js/pages/login_script.js"></script>
</body>
</html>