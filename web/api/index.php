<?php
require "model/Wallpaper.php";
require "model/Category.php";
require "../admin/inc/DB.php";

// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

$wallpaper = new Wallpaper(new DB());
$category = new Category(new DB());
$db = new DB();


function make_thumb($src, $dest, $desired_width)
{
    // Make directory if not made
    if (!is_dir($dest))
        mkdir($dest, 0755, true);
    // Get path info
    $pInfo = pathinfo($src);
    // Save the new path using the current file name
    $dest = $dest . "/" . "temp.jpg";
    // Do the rest of your stuff and things...
    $source_image = imagecreatefromjpeg($src);
    $width = imagesx($source_image);
    $height = imagesy($source_image);
    $desired_height = floor($height * ($desired_width / $width));
    $virtual_image = imagecreatetruecolor($desired_width, $desired_height);
    imagecopyresampled($virtual_image, $source_image, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);
    imagejpeg($virtual_image, $dest);
}


//switch ($action) {
//    case "read":
//        switch ($table) {
//            case "wallpapers":
//                if (isset($_GET['id'])) {
//                    echo $wallpaper->Read(mysqli_real_escape_string($db->getConnection(), $_GET['id']));
//                } else {
//                    echo $wallpaper->Read();
//                }
//                break;
//            case "category":
//                if (isset($_GET['id'])) {
//                    echo $category->Read(mysqli_real_escape_string($db->getConnection(), $_GET['id']));
//                } else {
//                    echo $category->Read();
//                }
//                break;
//        }
//        break;
//    case "edit":
//        switch ($table) {
//            case "wallpapers":
//                if (isset($_GET['id'])) {
//                    if (isset($_POST['title'])) {
//                        $wallpaper->Edit($_POST['id'], $_POST['title'], $_POST['des'], $_POST['category'], $_POST['tag']);
//                        echo json_encode(array("ok" => true));
//                    } else if (isset($_POST['tag'])) {
//                        $wallpaper->AddTag($_POST['id'], $_POST['tag']);
//                        echo json_encode(array("ok" => true));
//                    } else {
//                        echo json_encode(array("tag" => $_POST['tag']));
//                    }
//                } else {
//                    echo json_encode(array("ok" => false, "des" => "ID is null"));
//                }
//                break;
//            case "category":
//                if (isset($_POST['id'])) {
//                    if (isset($_POST['name']) && isset($_POST['title'])) {
//                        $category->Edit($_POST['id'], $_POST['name'], $_POST['title']);
//                        echo json_encode(array("ok" => true));
//                    }
//                } else {
//                    echo json_encode(array("ok" => false, "des" => "ID is null"));
//                }
//                break;
//        }
//        break;
//    case "delete":
//        switch ($table) {
//            case "category":
//                if (isset($_GET['id'])){
//                    $category->Delete($_GET['id']);
//                    echo json_encode(array("ok" => true));
//                }else{
//                    echo json_encode(array("ok" => false, "des" => "ID is null"));
//                }
//                break;
//        }
//        break;
//}

if (isset($_GET['type'])) {
    switch ($_GET['type']) {
        case 'ajax':
            session_start();

            if (isset($_SESSION['isLogin'])){
                if ($_SESSION['isLogin'] == true){
                   switch (@$_GET['action']){
                       //Wallpaper action
                       case "getWallpapers":
                           if (isset($_GET['id'])) {
                               echo $wallpaper->Read($_GET['id']);
                           } else {
                               echo $wallpaper->Read();
                           }
                           break;
                       case "addWallpaper":
                           if (!empty($_POST['title']) && !empty($_POST['description']) && !empty($_POST['category']) && !empty($_POST['tags'])) {
                               if (isset($_FILES['image'])) {
                                   $md5 = md5(microtime());
                                   $target_dir = "../uploads/" . $md5 . "/";
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
                                       if ($category->isExist($_POST['category'])) {
                                           mkdir("../uploads/" . $md5);
                                           if (move_uploaded_file($_FILES['image']['tmp_name'], $target_dir . "wallpaper." . $imageFileType)) {
                                               make_thumb("../uploads/" . $md5 . "/wallpaper." . $imageFileType, "../uploads/" . $md5 . "", 300);
                                               $wallpaper->Add($_POST['title'], $_POST['description'], $_POST['category'], $_POST['tags'],$_SESSION['name'], $md5,
                                                   "http://" . $_SERVER['HTTP_HOST'] . "/uploads/" . $md5 . "/" . "temp." . $imageFileType,
                                                   "http://" . $_SERVER['HTTP_HOST'] . "/uploads/" . $md5 . "/" . "wallpaper." . $imageFileType);
                                               echo json_encode(array("ok" => true,
                                                   "callback" => array("tempImage" => "http://" . $_SERVER['HTTP_HOST'] . "/uploads/" . $md5 . "/" . "temp." . $imageFileType, "wallpaperImage" => "http://" . $_SERVER['HTTP_HOST'] . "/uploads/" . $md5 . "/" . "wallpaper." . $imageFileType)));
                                           } else {
                                               echo json_encode(array("ok" => false, "des" => "there was an error uploading your file"));
                                               rmdir("../uploads/" . $md5);
                                               exit();
                                           }
                                       } else {
                                           echo json_encode(array("ok" => false, "des" => "category not found"));
                                           exit();
                                       }
                                   }
                               } else {
                                   echo json_encode(array("ok" => false, "des" => "'image' input is missing or incorrect"));
                               }
                           } else {
                               echo json_encode(array("ok" => false, "des" => "Some input are missing!"));
                           }
                           break;
                       case "addTag":
                           if (isset($_POST['id']) && isset($_POST['name'])){
                               $wallpaper->AddTag($_POST['id'],$_POST['name']);
                               echo json_encode(array("ok" => true));
                           }else{
                               echo json_encode(array("ok" => false, "des" => "Some input are missing!"));
                           }
                           break;
                       case "editWallpaper":
                           if (!empty($_POST['id']) && !empty($_POST['title']) && !empty($_POST['description']) && !empty($_POST['category']) && !empty($_POST['tags'])) {
                               if (!$category->isExist($_POST['category'])) {
                                   $wallpaper->Edit($_POST['id'],$_POST['title'],$_POST['description'],$_POST['category'],$_POST['tags']);
                                   echo json_encode(array(
                                       "ok"=>true,
                                       "callback"=>array(
                                           "id"=>$_POST['id'],
                                           "title"=>$_POST['title'],
                                           "description"=>$_POST['description'],
                                           "category"=>$_POST['category'],
                                           "tags"=>$_POST['tags']
                                       )
                                   ));
                               }else{
                                   echo json_encode(array("ok" => false, "des" => "category not found"));
                                   exit();
                               }
                           }else{
                               echo json_encode(array("ok" => false, "des" => "Some input are missing!"));
                               exit();
                           }
                           break;
                       case "deleteWallpaper":
                           if (!empty($_POST['id'])){
                               $wallpaper->Delete($_POST['id']);
                               echo json_encode(array("ok"=>true));
                           }else{
                               echo json_encode(array("ok"=>false,"des"=>"ID is required"));
                           }
                           break;
                       // Category action
                       case "getCategory":
                           if (isset($_POST['id'])) {
                               echo $category->Read($_POST['id']);
                           } else {
                               echo $category->Read();
                           }
                           break;
                       case "addCategory":
                           if (!empty($_POST['name']) && !empty($_POST['title'])){
                               if (!$category->isExist($_POST['name'])) {
                                   $category->Add($_POST['title'], $_POST['name']);
                                   echo json_encode(array("ok" => true));
                               }else{
                                   echo json_encode(array("ok" => false, "des" => "category exist"));
                                   exit();
                               }
                           }else{
                               echo json_encode(array("ok" => false, "des" => "Some input are missing!"));
                               exit();
                           }
                           break;
                       case "editCategory":
                           if (!empty($_POST['id']) && !empty($_POST['name']) && !empty($_POST['title'])){
                               if ($category->Edit($_POST['id'],$_POST['title'], $_POST['name'])){
                                   echo json_encode(array("ok" => true,"callback"=>array(
                                       "id"=>$_POST['id'],
                                       "name"=>$_POST['name'],
                                       "title"=>$_POST['title']
                                   )));
                               }else{
                                   echo json_encode(array("ok" => false, "des" => "Unable to edit this category"));
                                   exit();
                               }
                           }else{
                               echo json_encode(array("ok" => false, "des" => "Some input are missing!"));
                               exit();
                           }
                           break;
                       case "deleteCategory":
                           if(isset($_POST['id'])){
                               echo json_encode(array("ok" => true));
                               $category->Delete($_POST['id']);
                           }else{
                               exit();
                           }
                           break;
                       default:
                           echo json_encode(array("ok" => false, "des" => "Input is not acceptable"));
                           header("HTTP/1.0 403");
                   }
                }else{
                    echo json_encode(array("ok" => false, "des" => "Authentication failed"));
                    header("Set-Cookie: PHPSESSID=deleted; path=/; expires=Thu, 01 Jan 1970 00:00:00 GMT");
                    header("HTTP/1.0 403");
                    exit();
                }
            }else{
                echo json_encode(array("ok" => false, "des" => "Authentication is required"));
                header("Set-Cookie: PHPSESSID=deleted; path=/; expires=Thu, 01 Jan 1970 00:00:00 GMT");
                header("HTTP/1.0 403");
                exit();
            }
            break;
        case 'web':
            session_start();
            if (isset($_SERVER['HTTP_AUTHENTICATION'])) {
                if ($_SERVER['HTTP_AUTHENTICATION'] == 123456789) {
                    if (isset($_GET['action'])) {
                        switch ($_GET['action']) {
                            //Wallpaper action
                            case "getWallpapers":
                                if (isset($_POST['id'])) {
                                    echo $wallpaper->Read($_POST['id']);
                                } else {
                                    echo $wallpaper->Read();
                                }
                                break;
                            case "addWallpaper":
                                if (!empty($_POST['title']) && !empty($_POST['description']) && !empty($_POST['category']) && !empty($_POST['tags'])) {
                                    if (isset($_FILES['image'])) {
                                        $md5 = md5(microtime());
                                        $target_dir = "../uploads/" . $md5 . "/";
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
                                            if ($category->isExist($_POST['category'])) {
                                                mkdir("../uploads/" . $md5);
                                                if (move_uploaded_file($_FILES['image']['tmp_name'], $target_dir . "wallpaper." . $imageFileType)) {
                                                    make_thumb("../uploads/" . $md5 . "/wallpaper." . $imageFileType, "../uploads/" . $md5 . "", 300);
                                                    $wallpaper->Add($_POST['title'], $_POST['description'], $_POST['category'], $_POST['tags'],"WEB API", $md5,
                                                        "http://" . $_SERVER['HTTP_HOST'] . "/uploads/" . $md5 . "/" . "temp." . $imageFileType,
                                                        "http://" . $_SERVER['HTTP_HOST'] . "/uploads/" . $md5 . "/" . "wallpaper." . $imageFileType);
                                                    echo json_encode(array("ok" => true,
                                                        "callback" => array("tempImage" => "http://" . $_SERVER['HTTP_HOST'] . "/uploads/" . $md5 . "/" . "temp." . $imageFileType, "wallpaperImage" => "http://" . $_SERVER['HTTP_HOST'] . "/uploads/" . $md5 . "/" . "wallpaper." . $imageFileType)));
                                                } else {
                                                    echo json_encode(array("ok" => false, "des" => "there was an error uploading your file"));
                                                    rmdir("../uploads/" . $md5);
                                                    exit();
                                                }
                                            } else {
                                                echo json_encode(array("ok" => false, "des" => "category not found"));
                                                exit();
                                            }
                                        }
                                    } else {
                                        echo json_encode(array("ok" => false, "des" => "'image' input is missing or incorrect"));
                                    }
                                } else {
                                    echo json_encode(array("ok" => false, "des" => "Some input are missing!"));
                                }
                                break;
                            case "addTag":
                                if (isset($_POST['id']) && isset($_POST['name'])){
                                    $wallpaper->AddTag($_POST['id'],$_POST['name']);
                                    echo json_encode(array("ok" => true));
                                }else{
                                    echo json_encode(array("ok" => false, "des" => "Some input are missing!"));
                                }
                                break;
                            case "editWallpaper":
                                if (!empty($_POST['id']) && !empty($_POST['title']) && !empty($_POST['description']) && !empty($_POST['category']) && !empty($_POST['tags'])) {
                                    if (!$category->isExist($_POST['category'])) {
                                        $wallpaper->Edit($_POST['id'],$_POST['title'],$_POST['description'],$_POST['category'],$_POST['tags']);
                                        echo json_encode(array(
                                            "ok"=>true,
                                            "callback"=>array(
                                                "id"=>$_POST['id'],
                                                "title"=>$_POST['title'],
                                                "description"=>$_POST['description'],
                                                "category"=>$_POST['category'],
                                                "tags"=>$_POST['tags']
                                            )
                                        ));
                                    }else{
                                        echo json_encode(array("ok" => false, "des" => "category not found"));
                                        exit();
                                    }
                                }else{
                                    echo json_encode(array("ok" => false, "des" => "Some input are missing!"));
                                    exit();
                                }
                                break;
                            case "deleteWallpaper":
                                if (!empty($_POST['id'])){
                                    $wallpaper->Delete($_POST['id']);
                                    echo json_encode(array("ok"=>true));
                                }else{
                                    echo json_encode(array("ok"=>false,"des"=>"ID is required"));
                                }
                                break;
                            // Category action
                            case "getCategory":
                                if (isset($_POST['id'])) {
                                    echo $category->Read($_POST['id']);
                                } else {
                                    echo $category->Read();
                                }
                                break;
                            case "addCategory":
                                if (!empty($_POST['name']) && !empty($_POST['title'])){
                                    if (!$category->isExist($_POST['name'])) {
                                        $category->Add($_POST['title'], $_POST['name']);
                                        echo json_encode(array("ok" => true));
                                    }else{
                                        echo json_encode(array("ok" => false, "des" => "category exist"));
                                        exit();
                                    }
                                }else{
                                    echo json_encode(array("ok" => false, "des" => "Some input are missing!"));
                                    exit();
                                }
                                break;
                            case "editCategory":
                                if (!empty($_POST['id']) && !empty($_POST['name']) && !empty($_POST['title'])){
                                        if ($category->Edit($_POST['id'],$_POST['title'], $_POST['name'])){
                                            echo json_encode(array("ok" => true,"callback"=>array(
                                                "id"=>$_POST['id'],
                                                "name"=>$_POST['name'],
                                                "title"=>$_POST['title']
                                            )));
                                        }else{
                                            echo json_encode(array("ok" => false, "des" => "Unable to edit this category"));
                                            exit();
                                        }
                                }else{
                                    echo json_encode(array("ok" => false, "des" => "Some input are missing!"));
                                    exit();
                                }
                                break;
                            case "deleteCategory":
                                if(isset($_POST['id'])){
                                    echo json_encode(array("ok" => true));
                                    $category->Delete($_POST['id']);
                                }else{
                                    exit();
                                }
                                break;
                            default:
                                echo json_encode(array("ok" => false, "des" => "Input is not acceptable"));
                                header("HTTP/1.0 403");
                        }
                    } else {
                        echo json_encode(array("ok" => false, "des" => "Input is not acceptable"));
                        header("HTTP/1.0 404");

                    }
                } else {
                    echo json_encode(array("ok" => false, "des" => "Authentication failed"));
                    header("Set-Cookie: PHPSESSID=deleted; path=/; expires=Thu, 01 Jan 1970 00:00:00 GMT");
                    header("HTTP/1.0 403");
                    exit();
                }
            } else {
                echo json_encode(array("ok" => false, "des" => "Authentication is required"));
                header("Set-Cookie: PHPSESSID=deleted; path=/; expires=Thu, 01 Jan 1970 00:00:00 GMT");
                header("HTTP/1.0 403");
                exit();
            }
            break;

        default:
            echo json_encode(array("ok" => false, "des" => "Input is not acceptable"));
    }
} else {
    echo json_encode(array("ok" => false, "des" => "Input 'Type' required"));
}

