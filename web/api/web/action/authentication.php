<?php
if (!isset($_SERVER['HTTP_AUTHENTICATION']) || @$_SERVER['HTTP_AUTHENTICATION'] != API_KEY){
    http_response_code(401);
    exit();
}