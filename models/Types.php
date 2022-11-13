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

    public function create_one()
    {

        $query = 
            "INSERT INTO types SET
                name = :name;";

        $stmt = $this->conn->prepare($query);

        // should be validation here (stripping of html)

        $stmt->bindParam(':name', $this->name); 

        if($stmt->execute()) {
            return true;
        }

        printf("Error: %s.\n", $stmt->error);
        
        return false;
    }

    public function delete()
    {
        $query = 
            "DELETE FROM types WHERE
                id = :id;";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id);
        
        if($stmt->execute()) {
            return true;
        }

        printf("Error: %s.\n", $stmt->error);
        
        return false;
    }

    public function read_single()
    {
        $query = 
            "SELECT
                id,
                name
            FROM types
            WHERE id = ?
            LIMIT 0,1;";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->id = $row['id']; 
        $this->name = $row['name']; 
    }

    public function update()
    {
        $query = 
            "UPDATE types SET 
                name = :name
            WHERE
                id = :id;";

        $stmt = $this->conn->prepare($query);

        // should be validation here (stripping of html)

        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':name', $this->name); 

        if($stmt->execute()) {
            return true;
        }

        printf("Error: %s.\n", $stmt->error);
        
        return false;
    }
}