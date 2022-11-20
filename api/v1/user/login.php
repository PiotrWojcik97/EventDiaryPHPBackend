<?php

/**
 * @OA\Post(
 *     path="/api/v1/user/login.php",
 *     summary="Checks user login",
 *     tags={"Users"},
 *     @OA\RequestBody(
 *          @OA\MediaType(
 *              mediaType="json",
 *              @OA\Schema(
 *                  @OA\Property(
 *                      property="username",
 *                      type="string",
 *                      example="admin"
 *                  ),
 *                  @OA\Property(
 *                      property="password",
 *                      type="string",
 *                      example="admin"
 *                  )
 *              )
 *          )
 *     ),
 *     @OA\Response(response="200", description="Positive response"),
 *     @OA\Response(response="400", description="Bad request, no needed parameters specified"),
 * )
 */

error_reporting(E_ERROR | E_PARSE);

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
include_once '../../../utils/jwt_handler.php';

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

$user->read_user($data->username);

if( password_verify($data->password, $user->password) &&
    $data->username == $user->username)
{
    $headers = array('alg'=>'HS256','typ'=>'JWT');
	$payload = array('username'=>$user->username, 'exp'=>(time() + 86400)); // valid for one day
    $jwt = generate_jwt($headers, $payload);

    $reply = array(
        'res' => 'OK',
        'token' => $jwt
    );
}
else
{
    $reply = array(
        'res' => 'NOK',
    );
}

print_r(json_encode($reply));