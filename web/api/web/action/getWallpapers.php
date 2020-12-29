<?php

require "authentication.php";

if (isset($_POST['id'])){
    echo json_encode($wallpaper->Select($_POST['id']));
}elseif (isset($_POST['category'])){
    echo json_encode($wallpaper->Select(0,$_POST['category']));
}else{
    echo json_encode($wallpaper->Select());
}