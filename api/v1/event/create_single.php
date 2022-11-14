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
include_once '../../../models/EventsTime.php';

$database = new Database();
$db = $database->connect();

$event = new Events($db);
$events_time = new EventsTime($db);

$data = json_decode(file_get_contents("php://input"));

$event->user_id = $data->user_id; 
$event->type_id = $data->type_id; 
$event->name = $data->name; 
$event->short_description = $data->short_description; 
$event->long_description = $data->long_description;
$event->image_description = $data->image_description;

if($event->create_one())
{
    // if event was created, create associate dates to it (dates are stored per month in relative table) 
    $events_time->event_id = $event->read_last_id();

    $month = strtotime($data->start_time);
    $month = strtotime(date("Y-m", $month) . "-01T00:00:00");
    $end = strtotime($data->end_time);
    
    // if event happens during one month save it as it is
    if(date('m Y', $month) == date('m Y', $end))
    {
        $events_time->start_time = $data->start_time;
        $events_time->end_time = $data->end_time;
        
        if($events_time->create_one())
        {
            echo json_encode(
                array('message' => 'Event created')
            );
        }
    }
    // else if event happens during multiple months, chop dates and save it per month.
    else
    {
        // save beginning part of the event [start_time=event_start], [end_time=end_of_the_month]
        $events_time->start_time = $data->start_time;
        $events_time->end_time = date('Y-m-t',strtotime($data->start_time)) . "T23:59:59";
        
        $events_time->create_one();
        
        $month = strtotime("+1 month", $month);

        $end = strtotime("-1 month", $end);

        // save middle part of the event [start_time=start_of_the_month], [end_time=end_of_the_month]
        while($month < $end)
        {
            $events_time->start_time = date('Y-m', $month) . "-01T00:00:00";
            $events_time->end_time = date('Y-m-t', $month) . "T23:59:59";
            $events_time->create_one();

            $month = strtotime("+1 month", $month);
        }

        // save ending part of the event [start_time=start_of_the_month], [end_time=event_end]
        $events_time->start_time = date('Y-m', $month) . "-01T00:00:00";
        $events_time->end_time = $data->end_time;

        $events_time->create_one();
    }
}
else
{
    echo json_encode(
        array('message' => 'Event not created')
    );
}