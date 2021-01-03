<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/core/autoloader.php";
$wallpaper = new Wallpaper(new DB());

if (isset($_GET['id'])) {
    $wallpaper->Delete($_GET['id']);
}else{
    echo json_encode(array("ok"=>false,"code"=>400,"des"=>"ID is required"));
}