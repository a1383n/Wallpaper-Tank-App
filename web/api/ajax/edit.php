<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/core/autoloader.php";
$wallpaper = new Wallpaper(new DB());
$category = new Category(new DB());
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

if (!isset($_GET['t'])) {
    if (isset($_POST['id'])) {
        if (isset($_POST['title']) && isset($_POST['category']) && isset($_POST['tags'])) {
            $wallpaper->Update($_POST['id'], $_POST['title'], $_POST['category'], $_POST['tags']);
            echo json_encode(array("ok" => true, "code" => 200));
        } else {
            echo json_encode(array("ok" => false, "code" => 400, "des" => "Some input are missing"));
        }
    } else {
        echo json_encode(array("ok" => false, "code" => 400, "des" => "ID is required"));
    }
}else{
    if (isset($_POST['id'])) {
        if (isset($_POST['name']) && isset($_POST['color'])) {
            $category->Update($_POST['id'],$_POST['name'],$_POST['color']);
            echo json_encode(array("ok" => true, "code" => 200));
        } else {
            echo json_encode(array("ok" => false, "code" => 400, "des" => "Some input are missing"));
        }
    } else {
        echo json_encode(array("ok" => false, "code" => 400, "des" => "ID is required"));
    }
}