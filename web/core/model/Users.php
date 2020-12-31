<?php


class Users
{
    // database connection and table name
    private $conn;
    private $table_name = "users";

    /**
     * Users constructor.
     * @param $db
     */
    public function __construct($db)
    {
        $this->conn = $db;
    }

    /**
     * @return bool|mysqli_result
     */
    private function Select()
    {
        $result = $this->conn->Select($this->table_name);
        if (mysqli_num_rows($result) > 0) {
            return $result;
        } else {
            return false;
        }
    }

    /**
     * @param $username
     * @param $password
     * @return array|bool
     */
    public function Check($username, $password)
    {
        $username = escape_string($username,$this->conn);
        $password = escape_string($password,$this->conn);

        $result = $this->Select();

        while ($row = mysqli_fetch_assoc($result)) {
             if ($row['username'] == $username && password_verify($password,$row['password'])){
                 return array("name"=>$row['name'],"email"=>$row['email']);
             }
        }
        return false;
    }

}