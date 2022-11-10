<?php

header('Access-Control-Allow-Origin: *');
header('Consent-Type: application/json');

include_once '../config/Database.php';

$database = new Database();
$db = $database->connect();

$query =
    'INSERT INTO types (name) 
    VALUES
        ( \'meeting\'), 
        ( \'training\'),
        ( \'party\'),
        ( \'leisure\'),
        ( \'household duties\');';

$stmt = $db->prepare($query);
$stmt->execute();

return $stmt;