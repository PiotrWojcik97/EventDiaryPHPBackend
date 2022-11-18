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
include_once '../../../models/Events.php';

$database = new Database();
$db = $database->connect();

$event = new Events($db);

$result = $event->read_without_image();

if(!isset($_GET['id']))
{
    http_response_code(400);
    echo json_encode(
        array('message' => 'parameter ?id not present')
    );
    die();
}

$event->id = $_GET['id'];

$event->read_single();

$event_arr = array(
    'id' => $event->id,
    'user_id' => $event->user_id, 
    'type_id' => $event->type_id, 
    'name' => $event->name, 
    'start_time' => $event->start_time, 
    'end_time' => $event->end_time, 
    'short_description' => $event->short_description, 
    'long_description' => $event->long_description
);

print_r(json_encode($event_arr));