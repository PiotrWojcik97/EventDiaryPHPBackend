<?php

header('Access-Control-Allow-Origin: *');
header('Consent-Type: application/json');

include_once '../../../config/Database.php';
include_once '../../../models/Events.php';

$database = new Database();
$db = $database->connect();

$event = new Events($db);

$result = $event->read_without_image();

// get ID from API call (e.g. read_single.php?id=3)
$event->id = isset($_GET['id']) ? $_GET['id'] : die();

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