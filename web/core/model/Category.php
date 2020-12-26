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

}