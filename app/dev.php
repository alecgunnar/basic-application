<?php

use GuzzleHttp\Psr7\ServerRequest;

require('bootstrap.php');

$router = $container->get('framework.router');
$request = ServerRequest::fromGlobals();
$status = $router->processRequest($request);

var_dump((string) $request->getUri());

if ($status != 200) {
    die('not found');
}

$callable = $router->getRoute()
    ->getCallable();

$callable();
