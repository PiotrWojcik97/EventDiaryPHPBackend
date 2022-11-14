<?php

header('Access-Control-Allow-Origin: *');
header('Consent-Type: application/json');

include_once '../config/Database.php';

$database = new Database();
$db = $database->connect();

$query =
'CREATE TABLE events_time( 
    event_id int NOT NULL,
    start_time DATETIME NOT NULL,
    end_time DATETIME NOT NULL,
    FOREIGN KEY (event_id) REFERENCES events(id) );';

$stmt = $db->prepare($query);
$stmt->execute();

return $stmt;