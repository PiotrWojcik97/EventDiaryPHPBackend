<?php

if (isset($_SERVER['HTTP_ORIGIN'])) {
    header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
    header('Access-Control-Allow-Credentials: true');
    header('Access-Control-Max-Age: 86400');    // cache for 1 day
}

// Access-Control headers are received during OPTIONS requests
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS");         

    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
        header("Access-Control-Allow-Headers:        {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

    exit(0);
}


include_once '../../../config/Database.php';
include_once '../../../models/Types.php';

$database = new Database();
$db = $database->connect();

$type = new Types($db);

$result = $type->read();

// get ID from API call (e.g. read_single.php?id=3)
$type->id = isset($_GET['id']) ? $_GET['id'] : die();

$type->read_single();

$type_arr = array(
    'id' => $type->id,
    'name' => $type->name
);

print_r(json_encode($type_arr));