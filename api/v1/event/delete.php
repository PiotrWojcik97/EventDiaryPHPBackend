<?php

header('Access-Control-Allow-Origin: *');
header('Consent-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');
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

$event->id = $data->id;


if($event->delete())
{
    echo json_encode(
        array('message' => 'Event deleted')
    );
}
else
{
    echo json_encode(
        array('message' => 'Event not deleted')
    );
}