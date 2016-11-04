<?php

use GuzzleHttp\Psr7\ServerRequest;

$root = dirname(__DIR__);
require_once($root . '/vendor/autoload.php');

define('IS_DEBUG', true);

$container = Framework\bootstrap($root);
$app = $container->get('framework.application');

$response = $app->handleRequest();

$app->sendResponse($response);
