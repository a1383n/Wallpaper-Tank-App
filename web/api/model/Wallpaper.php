<?php

class Wallpaper
{
    // database connection and table name
    private $conn;
    private $table_name = "wallpapers";

    // object properties
    public $id;
    public $title;
    public $description;
    public $category;
    public $tag;
    public $likes;
    public $views;
    public $downloads;
    public $temp_image;
    public $wallpaper_image;

    /**
     * Wallpaper constructor.
     */
    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function Add($title,$description,$category,$tag,$author,$path,$temp_image,$wallpaper){
        if (isset($title) && isset($description) && isset($category) && isset($tag) && isset($path) && isset($temp_image) && isset($wallpaper)){

            return $this->conn->runQuery("INSERT INTO `wallpapers` (`id`, `title`, `dis`, `category`, `tags`, `likes`, `views`, `downloads`, `author`, `path`, `temp`, `wallpaper`) VALUES (NULL, '$title', '$description', '$description', '$tag', '0', '0', '0', 'WEB API', '$path', '$temp_image', '$wallpaper')");
        }else{
            return false;
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

    public function Edit($id,$title,$des,$category,$tag){
      $this->conn->runQuery("UPDATE `wallpapers` SET `title` = '$title' WHERE `wallpapers`.`id` =".$id);
      $this->conn->runQuery("UPDATE `wallpapers` SET `dis` = '$des' WHERE `wallpapers`.`id` =".$id);
      $this->conn->runQuery("UPDATE `wallpapers` SET `category` = '$category' WHERE `wallpapers`.`id` =".$id);
      $this->conn->runQuery("UPDATE `wallpapers` SET `tags` = '$tag' WHERE `wallpapers`.`id` =".$id);
    }

    public function Delete($id){
        $this->conn->runQuery("DELETE FROM `wallpapers` WHERE `wallpapers`.`id`=".$id);
    }

    public function AddTag($id,$tag){
        $result = $this->conn->runQuery("SELECT * FROM ".$this->table_name." WHERE id=".$id);
        $arr_tag = null;
        while ($row = mysqli_fetch_assoc($result)){
            $arr_tag = explode(",",$row['tags']);
        }
        array_push($arr_tag,$tag);
        $implode = implode(",",$arr_tag);
        $this->conn->runQuery("UPDATE `wallpapers` SET `tags` = '$implode' WHERE `wallpapers`.`id` =".$id);
    }
}