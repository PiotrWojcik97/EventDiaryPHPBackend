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
include_once '../../../models/Types.php';
include_once '../../../utils/jwt_handler.php';

$bearer_token = get_bearer_token();

if(!$bearer_token)
{
    http_response_code(401);
    echo json_encode(
        array('message' => 'no JWT token provided, Unauthorized')
    );
    die();
}

$is_jwt_valid = is_jwt_valid($bearer_token);

if(!$is_jwt_valid)
{
    http_response_code(401);
    echo json_encode(
        array('message' => 'Invalid JWT token, Unauthorized')
    );
    die();
}

$database = new Database();
$db = $database->connect();

$type = new Types($db);

if(isset($_GET['id']))
{
    $type->id = $_GET['id'];
    if($type->delete())
    {
        echo json_encode(
            array('message' => 'type deleted')
        );
    }
    else
    {
        http_response_code(400);
        echo json_encode(
            array('message' => 'type not deleted')
        );
    }
}
else
{
    http_response_code(400);
    echo json_encode(
        array('message' => 'no ?id given')
    );
}