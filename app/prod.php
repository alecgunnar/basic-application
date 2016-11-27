<?php

use GuzzleHttp\Psr7\ServerRequest;

$root = dirname(__DIR__);
require_once($root . '/vendor/autoload.php');

$container = Maverick\bootstrap($root);
$app = $container->get('application');

$response = $app->handleRequest(ServerRequest::fromGlobals());
$app->sendResponse($response);
