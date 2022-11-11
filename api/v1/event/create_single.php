<?php

header('Access-Control-Allow-Origin: *');
header('Consent-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers:
    Access-Control-Allow-Headers,
    Consent-Type,
    Access-Control-Allow-Methods,
    Authorization,
    X-Requested-With');

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