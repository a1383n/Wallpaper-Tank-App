<?php

require "authentication.php";

if (isset($_POST['id'])) {
    echo json_encode($category->Select($_POST['id']));
}else{
    echo json_encode($category->Select());
}