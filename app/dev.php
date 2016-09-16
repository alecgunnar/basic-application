<?php

use GuzzleHttp\Psr7\ServerRequest;

define('IS_DEBUG', true);

$container = require('bootstrap.php');

run(ServerRequest::fromGlobals());
