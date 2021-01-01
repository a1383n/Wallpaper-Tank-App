<?php
    session_start();
    require_once $_SERVER['DOCUMENT_ROOT']."/core/autoloader.php";
    $security = new Security();
    if (!$security->isLogin($_SESSION,$_COOKIE,$_SERVER)){
        header("Location: login.php");
    }
?>
<!DOCTYPE html>
<html lang="en">
<?php include "ui/header.php"; ?>
<body>
<?php include "ui/sidebar.php"; ?>

<?php include "ui/content.php";?>

<?php include "ui/footer.php"; ?>
</body>
</html>