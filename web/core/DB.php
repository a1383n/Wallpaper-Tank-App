<?php
require_once("autoloader.php");

class DB
{
    /**
     * Get database connection link
     * @return bool|false|mysqli
     */
    public function getConnection(){
        $conn = mysqli_connect(DATABASE_HOST,DATABASE_USERNAME,DATABASE_PASSWORD,DATABASE_NAME);
        mysqli_set_charset($conn,"utf8");
        return ($conn) ? $conn : false;
    }

    /**
     * @param $table
     * @return bool|mysqli_result
     */
    public function Select($table){
        $sql = "SELECT * FROM ".$table;
        return mysqli_query($this->getConnection(),$sql);
    }

    /**
     * Update selected row in TABLE_NAME
     * @param $id
     * @param $index_name
     * @param $value
     * @return bool
     */
    public function Update($id,$index_name,$value){
        $sql = "UPDATE ".WALLPAPER_TABLE_NAME." SET ".$index_name." = '".$value."' WHERE `wallpapers`.`id` = ".$id;
        $query = mysqli_query($this->getConnection(),$sql);
        return !$query;
    }

    /**
     * Run your sql line code
     * @param $sql
     * @return bool|mysqli_result
     */
    public function runQuery($sql){
        $query = mysqli_query($this->getConnection(),$sql);
        return $query;
    }
}