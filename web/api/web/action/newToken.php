<?php
require "authentication.php";

if (isset($_POST['token'])){
    $registration_ids->Insert($_POST['token']);
    print_message(true,200);
}else{
    print_message(false,400,"Token is required");
    http_response_code(400);
}