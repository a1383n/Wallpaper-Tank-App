<?php

require "authentication.php";

if (isset($_POST['id'])){
    $wallpaper->newLike($_POST['id']);
    print_message(true,200);
}else{
    http_response_code(400);
    print_message(false,400,"ID is required");
}
