<?php

// header('Access-Control-Allow-Origin: *');
// header('Consent-Type: application/json');
// header('Access-Control-Allow-Methods: POST');
// header('Access-Control-Allow-Headers:
//     Access-Control-Allow-Headers,
//     Consent-Type,
//     Access-Control-Allow-Methods,
//     Authorization,
//     X-Requested-With');

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

$data = json_decode(file_get_contents("php://input"));

$event->user_id = $data->user_id; 
$event->type_id = $data->type_id; 
$event->name = $data->name; 
$event->start_time = $data->start_time; 
$event->end_time = $data->end_time; 
$event->short_description = $data->short_description; 
$event->long_description = $data->long_description;

if($event->create_one())
{
    echo json_encode(
        array('message' => 'Event created')
    );
}
else
{
    echo json_encode(
        array('message' => 'Event not created')
    );
}