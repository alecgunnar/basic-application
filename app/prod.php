<?php

$root = dirname(__DIR__);
require_once($root . '/vendor/autoload.php');

$container = Maverick\bootstrap($root);
$app = $container->get('application');

$response = $app->handleRequest();
$app->sendResponse($response);
