<?php

/**
 * @OA\Delete(
 *     path="/api/v1/event/delete.php",
 *     summary="Delete event by given id",
 *     tags={"Events"},
 *     @OA\Parameter(
 *          name="id",
 *          in="query",
 *          required=true,
 *          description="id of event",
 *          @OA\Schema(
 *              type="integer"
 *          ),
 *     ),
 *     @OA\Response(response="200", description="Positive response"),
 *     @OA\Response(response="401", description="Authentication error, no JWT token provided"),
 *     @OA\Response(response="400", description="Bad request, no needed parameters specified"),
 *     security={{"bearerToken": {}}}
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
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, DELETE");         

    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
        header("Access-Control-Allow-Headers:        {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

    exit(0);
}

include_once '../../../config/Database.php';
include_once '../../../models/Events.php';
include_once '../../../models/EventsTime.php';
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

$event = new Events($db);
$event_time = new EventsTime($db);

if(!isset($_GET['id']))
{
    http_response_code(400);
    echo json_encode(
        array('message' => 'parameter ?id not present')
    );
    die();
}

$event->id = $_GET['id'];
$event_time->event_id = $_GET['id'];


if($event_time->delete())
{
    if($event->delete())
    {
        echo json_encode(
            array('message' => 'Event deleted')
        );
    }
    else
    {
        http_response_code(400);
        echo json_encode(
            array('message' => 'Event partially deleted')
        );
    }
}
else
{
    http_response_code(400);
    echo json_encode(
            array('message' => 'Event not deleted')
        );
}