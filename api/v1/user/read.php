<?php

/**
 * @OA\Get(
 *     path="/api/v1/user/read.php",
 *     summary="Get all users table",
 *     tags={"Users"},
 *     @OA\Response(response="200", description="Positive response")
 * )
 */

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

$users = new Users($db);

$result = $users->read_without_password();

$num_of_rows = $result->rowCount();

if($num_of_rows > 0)
{
    $users_arr = array();
    $users_arr['data'] = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC))
    {
        extract($row);

        $user_item = array(
            'id' => $id,
            'username' => $username
        );

        array_push($users_arr['data'], $user_item);
    }
    echo json_encode($users_arr);
}
else
{
    //no users
    echo json_encode(
        array('message' => "No Users Found")
    );
}