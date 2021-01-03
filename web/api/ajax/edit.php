<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/core/autoloader.php";
$wallpaper = new Wallpaper(new DB());

if (isset($_POST['id'])) {
    if (isset($_POST['title']) && isset($_POST['category']) && isset($_POST['tags'])) {
        $wallpaper->Update($_POST['id'],$_POST['title'],$_POST['category'],$_POST['tags']);
        echo json_encode(array("ok"=>true,"code"=>200));
    }else{
        echo json_encode(array("ok"=>false,"code"=>400,"des"=>"Some input are missing"));
    }
}else{
    echo json_encode(array("ok"=>false,"code"=>400,"des"=>"ID is required"));
}