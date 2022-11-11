<?php

class Types
{
    private $conn;

    public $id;
    public $name;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function read()
    {
        $query = 
            "SELECT id, name FROM types;";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }
}