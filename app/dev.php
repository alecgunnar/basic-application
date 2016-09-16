<?php

use GuzzleHttp\Psr7\ServerRequest;

define('IS_DEBUG', true);

$container = require('bootstrap.php');

$app = $container->get('framework.application');

$response = $app->handleRequest(ServerRequest::fromGlobals());

$app->sendResponse($response);
