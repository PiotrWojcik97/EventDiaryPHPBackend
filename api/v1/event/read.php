<?php

header('Access-Control-Allow-Origin: *');
header('Consent-Type: application/json');

include_once '../../../config/Database.php';
include_once '../../../models/Events.php';

$database = new Database();
$db = $database->connect();

$events = new Events($db);

$result = $events->read_without_image();

$num_of_rows = $result->rowCount();

if($num_of_rows > 0)
{
    $events_arr = array();
    $events_arr['data'] = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC))
    {
        extract($row);

        $user_item = array(
            'id' => $id,
            'user_id' => $user_id, 
            'type_id' => $type_id, 
            'name' => $name, 
            'start_time' => $start_time, 
            'end_time' => $end_time, 
            'short_description' => $short_description, 
            'long_description' => $long_description);

        array_push($events_arr['data'], $user_item);
    }
    echo json_encode($events_arr);
}
else
{
    //no events
    echo json_encode(
        array('message' => "No events Found")
    );
}