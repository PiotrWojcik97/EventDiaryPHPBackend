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

$event->type_id = isset($_GET['type_id']) ? $_GET['type_id'] : die();

$response = $event->read_id_by_type_id();

$num_of_rows = $response->rowCount();

if($num_of_rows > 0)
{
    $events_id_arr = array();

    while($row = $response->fetch(PDO::FETCH_ASSOC))
    {
        extract($row);

        array_push($events_id_arr, $row['id']);
    }
    
    
    foreach($events_id_arr as $id)
    {
        $event->id = $id;
        $event_time->event_id = $id;
        
        $event_time->delete();
        $event->delete();
    }

    echo json_encode(
        array('message' => "Events deleted")
    );
}
else
{
    //no events
    echo json_encode(
        array('message' => "No events Found")
    );
}
