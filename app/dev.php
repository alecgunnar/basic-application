<?php

use GuzzleHttp\Psr7\ServerRequest;

require('bootstrap.php');

$response = $container->get('framework.application')
    ->handleRequest(ServerRequest::fromGlobals());

var_dump($response);
