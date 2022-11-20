<?php
require("../vendor/autoload.php");

$openapi = \OpenApi\Generator::scan([$_SERVER['DOCUMENT_ROOT'] . '/api/v1']);

header('Content-Type: application/json');
echo $openapi->toJSON();