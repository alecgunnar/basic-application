<?php

use Symfony\Component\DependencyInjection\Dumper\PhpDumper;

$root = dirname(__DIR__);
require_once($root . '/vendor/autoload.php');

/*
 * Load the container
 */

$container = \Maverick\bootstrap($root, true);
$container = $container->get('service_container');

/*
 * Cache the container
 */

$container->compile();

$dumper = new PhpDumper($container);
$cached = $dumper->dump([
    'class' => 'CachedContainer'
]);

file_put_contents($container->getParameter('container_cache_file'), $cached);

/*
 * Cache the router
 *
 * Loading this service from the container
 * alone is sufficient. When the dispatcher
 * is instantiated, it automatically caches.
 */

$container->get('fast_route.cached_dispatcher');
