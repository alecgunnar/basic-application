<?php

$root = dirname(__DIR__);
require_once($root . '/vendor/autoload.php');

$container = Framework\bootstrap($root);
$app = $container->get('framework.application');

$response = $app->handleRequest();
$app->sendResponse($response);
