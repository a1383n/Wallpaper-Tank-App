<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/core/autoloader.php";
$wallpaper = new Wallpaper(new DB());
$category = new Category(new DB());
$db = new DB();
session_start();

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

if (!isset($_GET['t'])) {
    if (!empty($_POST['title']) && !empty($_POST['category']) && !empty($_POST['tags'])) {
        if (isset($_FILES['image'])) {
            $md5 = md5(microtime());
            $target_dir = "../../uploads/" . $md5 . "/";
            $imageFileType = strtolower(pathinfo(basename($_FILES['image']['name']), PATHINFO_EXTENSION));
            @$imagesize = getimagesize($_FILES['image']['tmp_name']);

            // Check if image file is a actual image or fake image
            if ($imagesize == false) {
                echo json_encode(array("ok" => false, "des" => "File is not image"));
                exit();
            } // check image size
            elseif ($_FILES['image']['size'] > 5242880 /*5M*/) {
                echo json_encode(array("ok" => false, "des" => "File larger than 5M"));
                exit();
            } //check image file type
            elseif ($imageFileType != "jpg" && $imageFileType != "jpeg") {
                echo json_encode(array("ok" => false, "des" => "only JPG & JPEG files are allowed"));
                exit();
            } else {
                mkdir("../../uploads/" . $md5);
                if (move_uploaded_file($_FILES['image']['tmp_name'], $target_dir . "wallpaper." . $imageFileType)) {
                    make_thumb("../../uploads/" . $md5 . "/wallpaper." . $imageFileType, "../../uploads/" . $md5 . "", 300);
                    $wallpaper->Insert($_POST['title'], $_POST['category'], $_POST['tags'], $_SESSION['name'], $md5, $imageFileType);
                    echo json_encode(array("ok" => true,
                        "callback" => array("tempImage" => UPLOAD_ROOT . $md5 . "/" . "temp." . $imageFileType, "wallpaperImage" => UPLOAD_ROOT . $md5 . "/" . "wallpaper." . $imageFileType)));
                } else {
                    echo json_encode(array("ok" => false, "des" => "there was an error uploading your file"));
                    rmdir("../../uploads/" . $md5);
                    exit();
                }
            }
        } else {
            echo json_encode(array("ok" => false, "des" => "'image' input is missing or incorrect"));
        }
    } else {
        echo json_encode(array("ok" => false, "des" => "Some input are missing!"));
    }
}else{
    if (isset($_POST['name']) && isset($_POST['color'])){
        $category->Add($_POST['name'],$_POST['color']);
        echo json_encode(array("ok"=>true));
    }else{
        echo json_encode(array("ok" => false, "des" => "Some input are missing!"));
    }
}