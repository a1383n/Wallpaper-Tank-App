<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . "/core/autoloader.php";
$security = new Security();
$db = new DB();
if (!$security->isLogin($_SESSION, $_SERVER, $_COOKIE)) {
    header("Location: admin/login.php");
} else {
    $isLogin = true;
    if (isset($_COOKIE['remember_me'])) {
        $_SESSION['name'] = $security->validationRememberMeCookie($_COOKIE['remember_me'],$_SERVER['REMOTE_ADDR'])['name'];
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<?php include "ui/header.php"; ?>
<body>
<?php include "ui/sidebar.php"; ?>

<?php include "ui/content.php"; ?>

<?php include "ui/footer.php"; ?>
</body>
</html>