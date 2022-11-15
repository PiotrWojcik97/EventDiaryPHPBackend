<?php

class EventsTime
{
    private $conn;

    public $event_id;
    public $start_time;
    public $end_time;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function read_single()
    {
        $query = 
            "SELECT
                event_id,
                start_time, 
                end_time
            FROM events_time
            WHERE id = ?
            LIMIT 0,1;";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->type_id = $row['start_time']; 
        $this->name = $row['end_time']; 
    }

    public function create_one()
    {
        $query = 
            "INSERT INTO events_time SET
                event_id = :event_id, 
                start_time = :start_time, 
                end_time = :end_time;";

        $stmt = $this->conn->prepare($query);

        // should be validation here (stripping of html)

        $stmt->bindParam(':event_id', $this->event_id); 
        $stmt->bindParam(':start_time', $this->start_time); 
        $stmt->bindParam(':end_time', $this->end_time); 

        if($stmt->execute()) {
            return true;
        }

        printf("Error: %s.\n", $stmt->error);
        
        return false;
    }

    public function delete()
    {
        $query = 
            "DELETE FROM events_time WHERE
                event_id = :event_id;";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':event_id', $this->event_id);
        
        if($stmt->execute()) {
            return true;
        }

        printf("Error: %s.\n", $stmt->error);
        
        return false;
    }

}