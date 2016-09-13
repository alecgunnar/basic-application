<?php

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

// Define some known directories
$appDir = __DIR__;
$rootDir = dirname($appDir);
$configDir = $appDir . '/config';

// Get the composer autoloader
require($rootDir . '/vendor/autoload.php');

// Build the container
$container = new ContainerBuilder();
$container->setParameter('app_dir', $appDir);
$container->setParameter('root_dir', $rootDir);
$container->setParameter('config_dir', $configDir);

$loader = new YamlFileLoader($container, new FileLocator($configDir));
$loader->load('services.yml');
