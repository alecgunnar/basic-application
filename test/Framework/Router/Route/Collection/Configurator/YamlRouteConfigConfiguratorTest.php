<?php

namespace Framework\Router\Route\Collection\Configurator;

use PHPUnit_Framework_TestCase;
use Symfony\Component\Finder\Finder;

class YamlRouteConfigConfiguratorTest extends PHPUnit_Framework_TestCase
{
    public function testLoadRoutesAddsRoutesToCollection()
    {

    }

    protected function getFinderInstance()
    {
        return $this->getMockBuilder(Finder::class)
            ->getMock();
    }

    protected function getInstance(Finder $finder = null, string $path = null)
    {
        return new YamlRouteConfigConfigurator(
            $finder ?? $this->getFinderInstance(),
            $path ?? 'path/'
        );
    }
}
