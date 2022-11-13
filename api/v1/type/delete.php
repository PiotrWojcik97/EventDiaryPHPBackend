<?php

// header('Access-Control-Allow-Origin: *');
// header('Consent-Type: application/json');
// header('Access-Control-Allow-Methods: DELETE');
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
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, DELETE");         

    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
        header("Access-Control-Allow-Headers:        {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

    exit(0);
}

include_once '../../../config/Database.php';
include_once '../../../models/Types.php';

$database = new Database();
$db = $database->connect();

$type = new Types($db);

$type->id = isset($_GET['id']) ? $_GET['id'] : die();

if($type->delete())
{
    echo json_encode(
        array('message' => 'type deleted')
    );
}
else
{
    echo json_encode(
        array('message' => 'type not deleted')
    );
}