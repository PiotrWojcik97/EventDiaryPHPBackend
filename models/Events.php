<?php

class Events
{
    private $conn;

    public $id;
    public $user_id; 
    public $type_id; 
    public $name; 
    public $start_time; 
    public $end_time; 
    public $short_description; 
    public $long_description; 
    public $image;
    public $image_description;


    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function read_without_image()
    {
        $query = 
            "SELECT
                id,
                user_id, 
                type_id, 
                name, 
                start_time, 
                end_time, 
                short_description, 
                long_description
            FROM events;";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }
    
    public function read_single()
    {
        $query = 
            "SELECT
                id,
                user_id, 
                type_id, 
                name, 
                start_time, 
                end_time, 
                short_description, 
                long_description
            FROM events
            WHERE id = ?
            LIMIT 0,1;";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->user_id = $row['user_id']; 
        $this->type_id = $row['type_id']; 
        $this->name = $row['name']; 
        $this->start_time = $row['start_time']; 
        $this->end_time = $row['end_time']; 
        $this->short_description = $row['short_description']; 
        $this->long_description = $row['long_description']; 
    }

    public function create_one()
    {

        $query = 
            "INSERT INTO events SET
                user_id = :user_id, 
                type_id = :type_id, 
                name = :name, 
                start_time = :start_time, 
                end_time = :end_time, 
                short_description = :short_description, 
                long_description = :long_description;";

        $stmt = $this->conn->prepare($query);

        // should be validation here (stripping of html)

        $stmt->bindParam(':user_id', $this->user_id); 
        $stmt->bindParam(':type_id', $this->type_id); 
        $stmt->bindParam(':name', $this->name); 
        $stmt->bindParam(':start_time', $this->start_time); 
        $stmt->bindParam(':end_time', $this->end_time); 
        $stmt->bindParam(':short_description', $this->short_description); 
        $stmt->bindParam(':long_description', $this->long_description);

        if($stmt->execute()) {
            return true;
        }

        printf("Error: %s.\n", $stmt->error);
        
        return false;
    }

    public function update()
    {

        $query = 
            "UPDATE events SET
                user_id = :user_id, 
                type_id = :type_id, 
                name = :name, 
                start_time = :start_time, 
                end_time = :end_time, 
                short_description = :short_description, 
                long_description = :long_description
            WHERE
                id = :id;";

        $stmt = $this->conn->prepare($query);

        // should be validation here (stripping of html)

        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':user_id', $this->user_id); 
        $stmt->bindParam(':type_id', $this->type_id); 
        $stmt->bindParam(':name', $this->name); 
        $stmt->bindParam(':start_time', $this->start_time); 
        $stmt->bindParam(':end_time', $this->end_time); 
        $stmt->bindParam(':short_description', $this->short_description); 
        $stmt->bindParam(':long_description', $this->long_description);

        if($stmt->execute()) {
            return true;
        }

        printf("Error: %s.\n", $stmt->error);
        
        return false;
    }

    public function delete()
    {
        $query = 
            "DELETE FROM events WHERE
                id = :id;";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id);
        
        if($stmt->execute()) {
            return true;
        }

        printf("Error: %s.\n", $stmt->error);
        
        return false;
    }

}