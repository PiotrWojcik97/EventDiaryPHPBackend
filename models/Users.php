<?php

class Users
{
    private $conn;

    public $id;
    public $username;
    public $password;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function read()
    {
        $query = 
            "SELECT id, username, password FROM users;";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }
    
    public function read_without_password()
    {
        $query = 
            "SELECT id, username FROM users;";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }
}