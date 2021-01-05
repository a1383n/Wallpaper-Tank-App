<?php


class Category
{
    // database connection and table name
    private $conn;
    private $table_name = "category";

    /**
     * Category constructor.
     * @param $db
     */
    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function Select($id = 0){
        $id = mysqli_escape_string($this->conn->getConnection(),$id);

        if ($id > 0){
            $sql = "SELECT * FROM ".$this->table_name." WHERE id=".$id." ORDER BY `$this->table_name`.`id`  DESC";
        }else{
            $sql = "SELECT * FROM ".$this->table_name." ORDER BY `$this->table_name`.`id`  DESC";
        }
        $result = $this->conn->runQuery($sql);
        $array = array();
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                array_push($array,$row);
            }

        }
        return $array;
    }

    public function Add($name,$color){
        $name = escape_string($name,$this->conn);
        $color = escape_string($color,$this->conn);

        $sql = "INSERT INTO `category` (`id`, `name`, `color`, `count`) VALUES (NULL,'$name' , '$color' , '0')";
        $this->conn->runQuery($sql);
    }

    public function Update($id,$name,$color){
        $id = escape_string($id,$this->conn);
        $name = escape_string($name,$this->conn);
        $color = escape_string($color,$this->conn);

        $this->conn->runQuery("UPDATE `$this->table_name` SET `name` = '$name' WHERE `$this->table_name`.`id` =" . $id);
        $this->conn->runQuery("UPDATE `$this->table_name` SET `color` = '$color' WHERE `$this->table_name`.`id` =" . $id);
    }

    public function Delete($id){
        $id = escape_string($id,$this->conn);
        $this->conn->runQuery("DELETE FROM `$this->table_name` WHERE `$this->table_name`.`id`=" . $id);
    }
}