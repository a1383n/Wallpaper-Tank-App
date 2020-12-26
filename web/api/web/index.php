<?php
require_once("../../core/autoloader.php");

function print_message($ok, $code, $des = null)
{
    if ($des) {
        echo json_encode(array("ok" => $ok, "code" => $code, "des" => $des));
    } else {
        echo json_encode(array("ok" => $ok, "code" => $code));
    }
}

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

$action = @$_GET['action'];
$wallpaper = new Wallpaper(new DB());
$category = new Category(new DB());

if (isset($action)) {
    switch ($action) {
        case "getWallpapers":
            include "action/getWallpapers.php";
            break;
        case "newLike":
            include "action/newLike.php";
            break;
        case "removeLike":
            include "action/removeLike.php";
            break;
        case "getCategory":
            include "action/getCategory.php";
            break;
        default:
            http_response_code(404);
            print_message(false, 404);
            exit();
    }
} else {
    http_response_code(400);
    print_message(false, 400);
    exit();
}
