<?php

class Database
{
    // private $host = 'localhost';
    // private $username = 'root';
    // private $password = '#21Gasdejr';

    private $host = 'eventdiarydb.mysql.database.azure.com';
    private $username = 'eventdiary';
    private $password = 'MyCoolPass1!';

    private $db_name = 'event_diary';
    private $conn;

    public function connect()
    {
        $this->conn = null;

        try
        {
            $this->conn = new PDO(
                'mysql:host=' . $this->host . ';dbname=' . $this->db_name,
                $this->username,
                $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch (PDOException $e)
        {
            echo 'Connection Error: ' . $e->getMessage();
        }

        return $this->conn;
    }

    // called only once to create database if not present
    public function init_db()
    {
        $this->conn = null;
        
        try
        {
            $this->conn = new PDO(
                'mysql:host=' . $this->host . ';',
                $this->username,
                $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch (PDOException $e)
        {
            echo 'Connection Error: ' . $e->getMessage();
        }
        
        $query = 'CREATE DATABASE ' . $this->db_name . ';';

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        return $stmt;
    }
}