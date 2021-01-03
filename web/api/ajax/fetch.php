<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/core/autoloader.php";
$db = new DB();


header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
if (!isset($_GET['t'])) {
    if (isset($_GET['id'])) {
        $result = $db->runQuery("SELECT * FROM wallpapers WHERE id=" . escape_string($_GET['id']));
        $array = array();
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $array = $row;
            }
        }
        echo json_encode(array("ok" => true, "code" => 200, "data" => $array));
    } else {
        $result = $db->Select("wallpapers");
        $data = array();
        while ($row = mysqli_fetch_row($result)) {
            $push = array(
                $row[0],
                $row[1],
                $row[2],
                $row[3],
                '<li class="fa fa-heart"></li>&nbsp;<span>' . $row[4] . '</span><br>' .
                '<li class="fa fa-eye"></li>&nbsp;<span>' . $row[5] . '</span><br>' .
                '<li class="fa fa-download">&nbsp;</li><span>' . $row[6] . '</span><br>',

                '<div class="btn-group" role="group"><buttom type="buttom" name="view" id="' . $row[0] . '" class="btn btn-primary" onclick="viewButton(' . $row[0] . ')">View</buttom>' .
                '<buttom type="buttom" name="edit" id="' . $row[0] . '" class="btn btn-secondary">Edit</buttom>' .
                '<buttom type="buttom" name="delete" id="' . $row[0] . '" class="btn btn-danger">Delete</buttom></div>'


            );
            array_push($data, $push);
        }

        $array = array("draw" => 36, "recordsTotal" => mysqli_num_rows($result), "recordsFiltered" => mysqli_num_rows($result), "data" => $data);

        echo json_encode($array);
    }
}else{
    if(isset($_GET['name'])){
        $result = $db->runQuery("SELECT * FROM category WHERE name='".escape_string($_GET['name'])."'");
        $array = array();
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $array = $row;
            }
        }
        echo json_encode(array("ok" => true, "code" => 200, "data" => $array));
    }else{
        $result = $db->Select("category");
        $array = array();
        if (mysqli_num_rows($result) > 0){
            while ($row = mysqli_fetch_assoc($result)){
                array_push($array,$row);
            }
            echo json_encode(array("ok"=>true,"code"=>200,"data"=>$array));
        }
    }
}
