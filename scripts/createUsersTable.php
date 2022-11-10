<?php

header('Access-Control-Allow-Origin: *');
header('Consent-Type: application/json');

include_once '../config/Database.php';

$database = new Database();
$db = $database->connect();

$query = 
    'CREATE TABLE users( 
        id int NOT NULL AUTO_INCREMENT,
        username varchar(255),
        password varchar(255),
        PRIMARY KEY(id) );';

$stmt = $db->prepare($query);
$stmt->execute();

return $stmt;