<?php

header('Access-Control-Allow-Origin: *');
header('Consent-Type: application/json');

include_once '../config/Database.php';

$database = new Database();
$db = $database->init_db();