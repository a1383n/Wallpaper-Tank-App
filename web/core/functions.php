<?php

/**
 * Include autoloader.php
 */
function inc_autoloader()
{
    require_once $_SERVER['DOCUMENT_ROOT'] . "/core/autoloader.php";
}

/**
 * Escape String
 * @param $string
 * @param null $conn
 * @return string
 */
function escape_string($string,$conn = null){
    if ($conn != null){
        return mysqli_escape_string($conn->getConnection(), $string);
    }else {
        $db = new DB();
        return mysqli_escape_string($db->getConnection(), $string);
    }
}

