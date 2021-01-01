<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/core/autoloader.php";
session_start();
$security = new Security();
if (!$security->isLogin($_SESSION,$_SERVER,$_COOKIE)) {
    header("Location: login.php");
}

//setcookie("remember_me",$security->rememberMeCookieValue("username","127.0.0.1","email"),time()+3600);

$value = $security->validationRememberMeCookie($_COOKIE['remember_me'], $_SERVER['REMOTE_ADDR']);

var_dump($value);