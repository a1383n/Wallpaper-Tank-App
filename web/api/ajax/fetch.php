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
                '<buttom type="buttom" name="edit" id="' . $row[0] . '" class="btn btn-secondary" onclick="editButton(' . $row[0] . ')">Edit</buttom>' .
                '<buttom type="buttom" name="delete" id="' . $row[0] . '" class="btn btn-danger" onclick="deleteButton(' . $row[0] . ')">Delete</buttom></div>'


            );
            array_push($data, $push);
        }

        $array = array("draw" => 1, "recordsTotal" => mysqli_num_rows($result), "recordsFiltered" => mysqli_num_rows($result), "data" => $data);

        echo json_encode($array);
    }
} else {
    if (isset($_GET['name'])) {
        $result = $db->runQuery("SELECT * FROM category WHERE name='" . escape_string($_GET['name']) . "'");
        $array = array();
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $array = $row;
            }
        }
        echo json_encode(array("ok" => true, "code" => 200, "data" => $array));
    } else {
        if (!isset($_GET['id'])) {
            $result = $db->Select("category");
            $array = array();
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_row($result)) {
                    array_push($array, array(
                        $row['0'],
                        $row['1'],
                        $row['3'],
                        '<div role="group" class="btn-group">
                    <button class="btn btn-secondary" onclick="editCategory(' . $row[0] . ')">Edit</button>
                    <button class="btn btn-danger" onclick="deleteCategory(' . $row[0] . ')">Delete</button>
                    </div>'
                    ));
                }
                echo json_encode(array("draw" => 2, "recordsTotal" => mysqli_num_rows($result), "recordsFiltered" => mysqli_num_rows($result), "data" => $array));
            }
        } else {
            $result = $db->runQuery("SELECT * FROM category WHERE id=" . escape_string($_GET['id']));
            $array = array();
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $array = $row;
                }
            }
            echo json_encode(array("ok" => true, "code" => 200, "data" => $array));
        }
    }
}