<?php


class RegistrationID
{
    // database connection and table name
    private $conn;
    private $table_name = "registration_ids";

    /**
     * RegistrationID constructor.
     * @param $db
     */
    public function __construct($db)
    {
        $this->conn = $db;
    }

    /**
     * @param $token
     */
    public function Insert($token){
        $token = mysqli_escape_string($this->conn->getConnection(),$token);

        $sql = "INSERT INTO `registration_ids` (`id`, `token`) VALUES (NULL, '$token')";
        $this->conn->runQuery($sql);
    }

    /**
     * @return mixed
     */
    public function Select(){
        return $this->conn->runQuery("SELECT * FROM `$this->table_name`");
    }
}