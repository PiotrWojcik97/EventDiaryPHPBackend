<?php

header('Access-Control-Allow-Origin: *');
header('Consent-Type: application/json');

include_once '../config/Database.php';

$database = new Database();
$db = $database->connect();

$hashed_admin = password_hash("admin", PASSWORD_DEFAULT);
$hashed_piotr = password_hash("piotr", PASSWORD_DEFAULT);
$hashed_dog = password_hash("dog", PASSWORD_DEFAULT);
$hashed_baby = password_hash("baby", PASSWORD_DEFAULT);
$hashed_woman = password_hash("woman", PASSWORD_DEFAULT);


$query =
    "INSERT INTO users (username, password) 
    VALUES
        ( 'admin', '$hashed_admin'), 
        ( 'piotr', '$hashed_piotr'),
        ( 'dog', '$hashed_dog'),
        ( 'baby', '$hashed_baby'),
        ( 'woman', '$hashed_woman');";

$stmt = $db->prepare($query);
$stmt->execute();

return $stmt;