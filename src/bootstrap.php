<?php

namespace Maverick;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\Config\FileLocator;
use Interop\Container\ContainerInterface;
use Acclimate\Container\ContainerAcclimator;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

function bootstrap(string $root = null, bool $debug = false): ContainerInterface
{
    $container = null;

    /*
     * Define some known directories
     */

    define('ROOT_DIR', $root ?? __DIR__);
    define('APP_DIR', $root . '/app');
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
     * Try to load the container from the cache
     */

    if (!$debug && file_exists(CONTAINER_CACHE_FILE)) {
        require_once(CONTAINER_CACHE_FILE);

        $class = CONTAINER_CACHE_CLASS;
        $container = new $class();
    }

    /*
     * Can't load the container from cache?
     * Build it from the config files
     */

    if (!($container instanceof Container)) {
        $container = new ContainerBuilder();
        $container->setParameter('app_dir', APP_DIR);
        $container->setParameter('root_dir', ROOT_DIR);
        $container->setParameter('config_dir', CONFIG_DIR);
        $container->setParameter('cache_dir', CACHE_DIR);

        $container->setParameter('is_debug', $debug);

        $loader = new YamlFileLoader($container, new FileLocator(CONFIG_DIR));
        $loader->load(PRIMARY_CONFIG_FILE);
    }

    /**
     * Acclimate the container to the nifty
     * ContainerInterface
     */

    $acclimator = new ContainerAcclimator();
    $container = $acclimator->acclimate($container);

    /**
     * Register the Whoops error handler
     */

    $container->get('whoops.run')
        ->register();

    return $container;
}
