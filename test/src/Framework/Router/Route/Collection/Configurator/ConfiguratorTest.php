<?php

namespace Framework\Router\Route\Collection\Configurator;

use PHPUnit_Framework_TestCase;
use Framework\Router\Route\RouteInterface;
use Framework\Router\Route\Loader\LoaderInterface;
use Framework\Router\Route\Collection\CollectionInterface;

class ConfiguratorTest extends PHPUnit_Framework_TestCase
{
    public function testConfiguratorAddsRoutesFromLoaderToCollection()
    {
        $file = 'routes.yml';

        $collection = $this->getMockCollection();

        $loader = $this->getMockLoader();
        $loader->expects($this->once())
            ->method('loadRoutes')
            ->with($file, $collection);

        $instance = $this->getInstance($loader, $file);

        $instance->configure($collection);
    }

    protected function getMockLoader()
    {
        return $this->getMockBuilder(LoaderInterface::class)
            ->getMock();
    }

    protected function getMockCollection()
    {
        return $this->getMockBuilder(CollectionInterface::class)
            ->getMock();
    }

    protected function getInstance(LoaderInterface $loader = null, string $file = null)
    {
        return new Configurator(
            $loader ?? $this->getMockLoader(),
            $file ?? 'routes.yml'
        );
    }
}
