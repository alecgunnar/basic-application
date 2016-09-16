<?php

use GuzzleHttp\Psr7\ServerRequest;

$container = require('bootstrap.php');

run(ServerRequest::fromGlobals());
