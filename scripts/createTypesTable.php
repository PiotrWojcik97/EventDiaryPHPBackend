<?php

header('Access-Control-Allow-Origin: *');
header('Consent-Type: application/json');

include_once '../config/Database.php';

$database = new Database();
$db = $database->connect();

$query = 
    'CREATE TABLE types( 
        id int NOT NULL AUTO_INCREMENT,
        name varchar(255),
        color varchar(255),
        PRIMARY KEY(id) );';

$stmt = $db->prepare($query);
$stmt->execute();

return $stmt;