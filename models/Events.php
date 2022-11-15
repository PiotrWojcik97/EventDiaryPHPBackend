<?php

class Events
{
    private $conn;

    public $id;
    public $user_id; 
    public $type_id; 
    public $name; 
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
                long_description,
                image_description
            FROM events;";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    public function read_month($month, $year)
    {
        $next_month = $month + 1;
        $next_year = $year;
        if($next_month > 12)
        {
            $next_month = 1;
            $next_year += 1;
        }

        $query = 
            "SELECT
                e.id,
                e.user_id, 
                e.type_id,
                t.start_time,
                t.end_time,
                e.name,
                e.short_description,
                e.long_description,
                e.image_description
            FROM events e
            INNER JOIN events_time t
            ON e.id = t.event_id
            WHERE t.start_time >= '$year-$month-01' and 
                  t.start_time < '$next_year-$next_month-01'
            ;";

        $stmt = $this->conn->prepare($query);

        $stmt->execute();

        return $stmt;
    }
    
    public function read_last_id()
    {
        $query = 
            "SELECT LAST_INSERT_ID();";
        
        $stmt = $this->conn->prepare($query);
        
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row['LAST_INSERT_ID()'];
    }

    public function read_single()
    {
        $query = 
            "SELECT
                id,
                user_id, 
                type_id, 
                name, 
                short_description, 
                long_description,
                image_description
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
        $this->short_description = $row['short_description']; 
        $this->long_description = $row['long_description']; 
        $this->image_description = $row['image_description']; 
    }

    public function create_one()
    {
        $query = 
            "INSERT INTO events SET
                user_id = :user_id, 
                type_id = :type_id, 
                name = :name, 
                short_description = :short_description, 
                long_description = :long_description,
                image_description = :image_description;";

        $stmt = $this->conn->prepare($query);

        // should be validation here (stripping of html)

        $stmt->bindParam(':user_id', $this->user_id); 
        $stmt->bindParam(':type_id', $this->type_id); 
        $stmt->bindParam(':name', $this->name); 
        $stmt->bindParam(':short_description', $this->short_description); 
        $stmt->bindParam(':long_description', $this->long_description);
        $stmt->bindParam(':image_description', $this->image_description);

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
                short_description = :short_description, 
                long_description = :long_description,
                image_description = :image_description
            WHERE
                id = :id;";

        $stmt = $this->conn->prepare($query);

        // should be validation here (stripping of html)

        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':user_id', $this->user_id); 
        $stmt->bindParam(':type_id', $this->type_id); 
        $stmt->bindParam(':name', $this->name); 
        $stmt->bindParam(':short_description', $this->short_description); 
        $stmt->bindParam(':long_description', $this->long_description);
        $stmt->bindParam(':image_description', $this->image_description);

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