<?php

use Symfony\Component\DependencyInjection\Dumper\PhpDumper;

/*
 * Let the bootstrap know we're building
 */

define('IS_BUILD', true);

/*
 * Load the container
 */

$container = require('bootstrap.php');

/*
 * Cache the container
 */

$container->compile();

$dumper = new PhpDumper($container);
$cached = $dumper->dump([
    'class' => CONTAINER_CACHE_CLASS
]);

file_put_contents(CONTAINER_CACHE_FILE, $cached);

/*
 * Cache the router
 *
 * Loading this service from the container
 * alone is sufficient. When the dispatcher
 * is instantiated, it automatically caches.
 */

$container->get('fast_route.cached_dispatcher');
