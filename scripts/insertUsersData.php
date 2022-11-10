<?php

header('Access-Control-Allow-Origin: *');
header('Consent-Type: application/json');

include_once '../config/Database.php';

$database = new Database();
$db = $database->connect();

$query =
    'INSERT INTO users (username, password) 
    VALUES
        ( \'admin\', \'admin\'), 
        ( \'piotr\', \'piotr\'),
        ( \'dog\', \'dog\'),
        ( \'baby\', \'baby\'),
        ( \'woman\', \'woman\');';

$stmt = $db->prepare($query);
$stmt->execute();

return $stmt;