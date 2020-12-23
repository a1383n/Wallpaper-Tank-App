<?php


class Category
{
    // database connection and table name
    private $conn;
    private $table_name = "category";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function Add($title,$name){
        if (!empty($title) && !empty($name)){
            return $this->conn->runQuery("INSERT INTO `category` (`id`, `name`, `title`, `count`) VALUES (NULL, '$name','$title', '0');");
        }else{
            false;
        }
    }
    public function Read($id = 0){
        if ($id != 0){
            $sql = "SELECT * FROM ".$this->table_name." WHERE id=".$id;
        }else{
            $sql = "SELECT * FROM ".$this->table_name;
        }
        $result = $this->conn->runQuery($sql);
        $array = array();
        $array['items'] = array();
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                array_push($array['items'], $row);

            }

        }
        return json_encode($array);
    }

    public function Edit($id,$title,$name){
        $this->conn->runQuery("UPDATE `category` SET `name` = '$name' WHERE `category`.`id` =".$id);
        return $this->conn->runQuery("UPDATE `category` SET `title` = '$title' WHERE `category`.`id` =".$id);
    }

    public function Delete($id){
        $this->conn->runQuery("DELETE FROM `category` WHERE `category`.`id`=".$id);
    }

    public function isExist($name){
        $result = $this->conn->runQuery("SELECT * FROM ".$this->table_name);
        if (mysqli_num_rows($result) > 0){
            while ($row = mysqli_fetch_assoc($result)){
                if ($row['name'] == $name){
                    return true;
                    break;
                }
            }
        }else{
            return false;
        }
    }

    public function addCount($name){

    }
}