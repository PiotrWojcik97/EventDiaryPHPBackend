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
include_once '../../../models/Types.php';

$database = new Database();
$db = $database->connect();

$types = new Types($db);

$result = $types->read();

$num_of_rows = $result->rowCount();

if($num_of_rows > 0)
{
    $types_arr = array();
    $types_arr['data'] = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC))
    {
        extract($row);

        $type_item = array(
            'id' => $id,
            'name' => $name
        );

        array_push($types_arr['data'], $type_item);
    }
    echo json_encode($types_arr);
}
else
{
    //no types
    echo json_encode(
        array('message' => "No types Found")
    );
}