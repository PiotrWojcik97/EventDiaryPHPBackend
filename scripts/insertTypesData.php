<?php

header('Access-Control-Allow-Origin: *');
header('Consent-Type: application/json');

include_once '../config/Database.php';

$database = new Database();
$db = $database->connect();

$query =
    "INSERT INTO types (color, name) 
    VALUES
        ('#A79AFF9F', 'meeting'), 
        ('#FFBEBC9F', 'training'),
        ('#FFF5BA9F', 'party'),
        ('#85E3FF9F', 'leisure'),
        ('#AFF8DB9F', 'household duties');";

$stmt = $db->prepare($query);
$stmt->execute();

return $stmt;