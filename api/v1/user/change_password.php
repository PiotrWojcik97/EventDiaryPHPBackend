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
include_once '../../../models/Users.php';

$database = new Database();
$db = $database->connect();

$user = new Users($db);

$data = json_decode(file_get_contents("php://input"));

if(!isset($data->username))
{
    http_response_code(400);
    echo json_encode(
        array('message' => 'parameter :username not present')
    );
    die();
}
if(!isset($data->password))
{
    http_response_code(400);
    echo json_encode(
        array('message' => 'parameter :password not present')
    );
    die();
}
if(!isset($data->newPassword))
{
    http_response_code(400);
    echo json_encode(
        array('message' => 'parameter :newPassword not present')
    );
    die();
}

$user->read_user($data->username);

if( $data->username == $user->username &&
    $data->password == $user->password)
{
    $user->password = $data->newPassword;
    $user->update();
    
    $reply = array(
        'res' => 'OK',
    );
}
else
{
    http_response_code(400);
    $reply = array(
        'res' => 'NOK',
    );
}

print_r(json_encode($reply));