<?php

class Wallpaper
{
    // database connection and table name
    private $conn;
    private $table_name = "wallpapers";

    /**
     * Wallpaper constructor.
     * @param $db
     */
    public function __construct($db)
    {
        $this->conn = $db;
    }

    /**
     * @param $title
     * @param $category
     * @param $tags
     * @param $author
     * @param $path
     * @param $image_type
     */
    public function Insert($title, $category, $tags, $author, $path, $image_type)
    {
        $title = mysqli_escape_string($this->conn->getConnection(), $title);
        $category = mysqli_escape_string($this->conn->getConnection(), $category);
        $tags = mysqli_escape_string($this->conn->getConnection(), $tags);

        $temp = UPLOAD_ROOT . $path . "/temp." . $image_type;
        $wallpaper = UPLOAD_ROOT . $path . "/wallpaper." . $image_type;
        $sql = "INSERT INTO `wallpapers` (`id`, `title`, `category`, `tags`, `likes`, `views`, `downloads`, `author`, `path`, `temp`, `wallpaper`) VALUES 
        (NULL, '$title', '$category', '$tags', '0', '0', '0', '$author', '$path', '$temp', '$wallpaper')";
        $this->conn->runQuery($sql);
    }

    /**
     * @param $id
     */
    public function Delete($id)
    {
        $id = mysqli_escape_string($this->conn->getConnection(), $id);
        $this->conn->runQuery("DELETE FROM `$this->table_name` WHERE `$this->table_name`.`id`=" . $id);
    }

    /**
     * @param int $id
     * @param null $category
     * @return array
     */
    public function Select($id = 0,$category = null)
    {
        $id = mysqli_escape_string($this->conn->getConnection(), $id);
        $category = mysqli_escape_string($this->conn->getConnection(), $category);

        if ($id > 0) {
            $sql = "SELECT * FROM " . $this->table_name . " WHERE id=" . $id . " ORDER BY `$this->table_name`.`id`  DESC";
        }elseif ($category != null){
            $sql = "SELECT * FROM " . $this->table_name . " WHERE category='" . $category . "' ORDER BY `$this->table_name`.`id`  DESC";
        } else {
            $sql = "SELECT * FROM " . $this->table_name . " ORDER BY `$this->table_name`.`id`  DESC";
        }
        $result = $this->conn->runQuery($sql);
        $array = array();
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                array_push($array, $row);
            }

        }
        return $array;
    }

    /**
     * @param $id
     * @param $title
     * @param $category
     * @param $tags
     */
    public function Update($id, $title, $category, $tags)
    {
        $id = mysqli_escape_string($this->conn->getConnection(), $id);
        $title = mysqli_escape_string($this->conn->getConnection(), $title);
        $category = mysqli_escape_string($this->conn->getConnection(), $category);
        $tags = mysqli_escape_string($this->conn->getConnection(), $tags);

        $this->conn->runQuery("UPDATE `$this->table_name` SET `title` = '$title' WHERE `$this->table_name`.`id` =" . $id);
        $this->conn->runQuery("UPDATE `$this->table_name` SET `category` = '$category' WHERE `$this->table_name`.`id` =" . $id);
        $this->conn->runQuery("UPDATE `$this->table_name` SET `tags` = '$tags' WHERE `$this->table_name`.`id` =" . $id);
    }

    /**
     * Add new Like
     * @param $id
     */
    public function newLike($id)
    {
        $sql = "SELECT * FROM " . $this->table_name . " WHERE id=" . $id;
        $result = $this->conn->runQuery($sql);
        if (mysqli_num_rows($result) > 0) {
            $like = 0;
            while ($row = mysqli_fetch_array($result)) {
                $like = $row['likes'];
            }
            $like += 1;
            $this->conn->runQuery("UPDATE `$this->table_name` SET `likes` = '$like' WHERE `$this->table_name`.`id` =" . $id);
        }
    }

    /**
     * Remove previous like
     * @param $id
     */
    public function removeLike($id)
    {
        $sql = "SELECT * FROM " . $this->table_name . " WHERE id=" . $id;
        $result = $this->conn->runQuery($sql);
        if (mysqli_num_rows($result) > 0) {
            $like = 0;
            while ($row = mysqli_fetch_array($result)) {
                $like = $row['likes'];
            }
            $like -= 1;
            $this->conn->runQuery("UPDATE `$this->table_name` SET `likes` = '$like' WHERE `$this->table_name`.`id` =" . $id);
        }
    }
}