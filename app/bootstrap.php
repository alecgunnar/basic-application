<?php

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

// Define some known directories
$rootDir = dirname(__DIR__);
$configDir = __DIR__ . '/config';

// Get the composer autoloader
require($rootDir . '/vendor/autoload.php');

// Build the container
$container = new ContainerBuilder();
$container->setParameter('config_dir', $configDir);

$loader = new YamlFileLoader($container, new FileLocator($configDir));
$loader->load('services.yml');
