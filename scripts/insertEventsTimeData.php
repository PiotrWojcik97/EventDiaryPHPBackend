<?php

header('Access-Control-Allow-Origin: *');
header('Consent-Type: application/json');

include_once '../config/Database.php';

$database = new Database();
$db = $database->connect();

$query =
    "INSERT INTO events_time (
        event_id, 
        start_time, 
        end_time)
    VALUES
        ('1',
        '2022-11-02T01:01:00', 
        '2022-11-05T14:59:00'),
        ('2',
        '2022-11-01T12:00:00', 
        '2022-11-01T16:00:00'),
        ('3', 
        '2022-11-03T12:00:00', 
        '2022-11-03T13:00:00'),
        ('4', 
        '2022-11-03T13:30:00', 
        '2022-11-03T17:00:00'),
        ('5',
        '2022-11-03T17:00:00', 
        '2022-11-03T19:00:00'),
        ('6',
        '2022-11-03T13:30:00', 
        '2022-11-03T17:00:00');";

$stmt = $db->prepare($query);
$stmt->execute();

return $stmt;