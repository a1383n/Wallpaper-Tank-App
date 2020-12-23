<?php
define("HOST","localhost");
define("USERNAME","root");
define("PASSWORD","");
define("NAME","wallpaper-app");
define("WALLPAPER_TABLE_NAME","wallpapers");
define("USER_TABLE_NAME","users");

class DB
{
    /**
     * Get database connection link
     * @return bool|false|mysqli
     */
    public function getConnection(){
        $conn = mysqli_connect(HOST,USERNAME,PASSWORD,NAME);
        mysqli_set_charset($conn,"uft8");
        return ($conn) ? $conn : false;
    }

    /**
     * Insert Into TABLE_NAME set in define
     * @param $title
     * @param $dis
     * @param $author
     * @param $path
     * @param $temp
     * @param $wallpaper
     * @return bool|mysqli_result
     */
    public function Insert($title,$dis,$author,$path,$temp,$wallpaper){
        $sql = "INSERT INTO `".WALLPAPER_TABLE_NAME."` (`id`, `title`, `dis`, `likes`, `views`, `download`, `author`, `path`, `temp`, `wallpaper`) VALUES (NULL, '$title', '$dis', '0', '0', '0', '$author', '$path', '$temp', '$wallpaper')";
        $query = mysqli_query($this->getConnection(),$sql);
        return (!$query) ? $query : false;
    }

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