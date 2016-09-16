<?php

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

/*
 * Define some known directories
 */

define('APP_DIR', __DIR__);
define('ROOT_DIR', dirname(APP_DIR));
define('CONFIG_DIR', APP_DIR . '/config');
define('CACHE_DIR', ROOT_DIR . '/cache');

/*
 * Define some known files
 */

define('PRIMARY_CONFIG_FILE', CONFIG_DIR . '/config.yml');
define('CONTAINER_CACHE_FILE', CACHE_DIR . '/container.php');

/*
 * Class for the cached container
 */

define('CONTAINER_CACHE_CLASS', 'CachedContainer');

/*
 * Define the application's state
 */

if (!defined('IS_DEBUG')) {
    define('IS_DEBUG', false);
}

if (!defined('IS_BUILD')) {
    define('IS_BUILD', false);
}

/*
 * Get the composer autoloader
 */

require(ROOT_DIR . '/vendor/autoload.php');

/*
 * Quick and easy callable to run the app
 */

function run(ServerRequestInterface $request): ResponseInterface {
    global $container;

    $request = $container->get('framework.application');
    return $app->handleRequest($request);
}

/*
 * Try to load the container from the cache
 */

if (!IS_DEBUG && !IS_BUILD && file_exists(CONTAINER_CACHE_FILE)) {
    require_once(CONTAINER_CACHE_FILE);

    $class = CONTAINER_CACHE_CLASS;
    return new $class();
}

/*
 * Can't load the container from cache?
 * Build it from the config files
 */

$container = new ContainerBuilder();
$container->setParameter('app_dir', APP_DIR);
$container->setParameter('root_dir', ROOT_DIR);
$container->setParameter('config_dir', CONFIG_DIR);
$container->setParameter('cache_dir', CACHE_DIR);

$container->setParameter('is_debug', IS_DEBUG);
$container->setParameter('is_build', IS_BUILD);

$loader = new YamlFileLoader($container, new FileLocator(CONFIG_DIR));
$loader->load(PRIMARY_CONFIG_FILE);

return $container;
