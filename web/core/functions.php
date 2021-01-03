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
function escape_string($string, $conn = null)
{
    if ($conn != null) {
        return mysqli_escape_string($conn->getConnection(), $string);
    } else {
        $db = new DB();
        return mysqli_escape_string($db->getConnection(), $string);
    }
}

/**
 * @param $src
 * @param $dest
 * @param $desired_width
 */
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

