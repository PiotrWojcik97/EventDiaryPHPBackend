<?php

class Users
{
    private $conn;
    private $table = 'users';

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
            'SELECT u.id, u.username, u.password
            FROM' . $this->table . ' as u';

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }
}