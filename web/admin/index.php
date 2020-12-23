<?php
session_start();
if (isset($_SESSION['isLogin']) && $_SESSION['isLogin'] == true){
    header("Location: panel.php");
}else{
    http_response_code(403);
    header("Location: login.php");
}