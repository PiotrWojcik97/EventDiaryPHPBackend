<?php

header('Access-Control-Allow-Origin: *');
header('Consent-Type: application/json');

include_once '../config/Database.php';

$database = new Database();
$db = $database->connect();

$query =
'CREATE TABLE events( 
    id int NOT NULL AUTO_INCREMENT,
    user_id int NOT NULL,
    type_id int NOT NULL,
    name VARCHAR(255) NOT NULL,
    start_time DATETIME NOT NULL,
    end_time DATETIME NOT NULL,
    short_description TEXT,
    long_description TEXT,
    image LONGBLOB,
    PRIMARY KEY (id),
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (type_id) REFERENCES types(id) );';

$stmt = $db->prepare($query);
$stmt->execute();

return $stmt;