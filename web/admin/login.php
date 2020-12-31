<?php
session_start();
if (isset($_SESSION['isLogin']) && $_SESSION['isLogin'] == true){
    header("Location: panel.php");
}

$login_successful = '
               <div class="alert alert-success">
                    <h5><i class="icon fa fa-check-circle"></i>&nbsp;<span id="">Successful!</span></h5>
                    <span>Moving to admin panel ...</span><br><span></span>
                </div>
';
$login_failure = '
               <div class="alert alert-danger">
                    <h5><i class="icon fa fa-ban"></i>&nbsp;<span id="">Error!</span></h5>
                    <span>Wrong username or password</span><br>
                </div>
';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Title</title>
    <link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="../assets/js/jquery-3.5.1.min.js"></script>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
            <div class="content-box">
                <h4 class="h4 text-center">Login</h4>
                <form role="form" action="login.php" method="post">
                    <div class="form-group">
                        <label for="login-form-username-input">Username</label>
                        <input type="text" name="username" class="form-control" id="login-form-username-input" required>
                    </div>
                    <div class="form-group">
                        <label for="login-form-username-input">Password</label>
                        <input type="password" name="password" class="form-control" id="login-form-password-input"
                               required>
                    </div>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="login-form-remember-check"
                               name="remember_me" value="true">
                        <label class="custom-control-label" for="login-form-remember-check">Remember Me</label>
                    </div>
                    <div class="form-group">
                        <button type="submit" id="login-form-submit-btn"
                                class="btn btn-lg btn-primary btn-block text-uppercase mt-3">Login
                        </button>
                    </div>
                    <?php
                    if (isset($_POST['username']) && isset($_POST['password'])) {
                        require_once $_SERVER['DOCUMENT_ROOT'] . "/core/autoloader.php";
                        $username = $_POST['username'];
                        $password = $_POST['password'];
                        $users = new Users(new DB());
                        $result = $users->Check($username, $password);
                        if (is_array($result)) {
                            $_SESSION['isLogin'] = true;
                            $_SESSION['name'] = $result['name'];
                            $_SESSION['email'] = $result['email'];

                            if (isset($_POST['remember_me']) == true){

                            }

                            echo $login_successful;
                            echo '<script>
                                    $(".form-group , .custom-control").hide();
                                    
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
                    ?>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="../assets/js/bootstrap.min.js"></script>
<script src="../assets/js/bootstrap.bundle.js"></script>
</body>
</html>