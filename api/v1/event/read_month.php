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

$events = new Events($db);

$data = json_decode(file_get_contents("php://input"));

$result = $events->read_month($data->month, $data->year);

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
            'long_description' => $long_description,
            'image_description' => $image_description
        );

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

