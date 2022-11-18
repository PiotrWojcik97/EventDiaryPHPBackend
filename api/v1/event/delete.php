<?php

if (isset($_SERVER['HTTP_ORIGIN'])) {
    header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
    header('Access-Control-Allow-Credentials: true');
    header('Access-Control-Max-Age: 86400');    // cache for 1 day
}

// Access-Control headers are received during OPTIONS requests
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, DELETE");         

    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
        header("Access-Control-Allow-Headers:        {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

    exit(0);
}

include_once '../../../config/Database.php';
include_once '../../../models/Events.php';
include_once '../../../models/EventsTime.php';

$database = new Database();
$db = $database->connect();

$event = new Events($db);
$event_time = new EventsTime($db);

if(!isset($_GET['id']))
{
    http_response_code(400);
    echo json_encode(
        array('message' => 'parameter ?id not present')
    );
    die();
}

$event->id = $_GET['id'];
$event_time->event_id = $_GET['id'];


if($event_time->delete())
{
    if($event->delete())
    {
        echo json_encode(
            array('message' => 'Event deleted')
        );
    }
    else
    {
        http_response_code(400);
        echo json_encode(
            array('message' => 'Event partially deleted')
        );
    }
}
else
{
    http_response_code(400);
    echo json_encode(
            array('message' => 'Event not deleted')
        );
}