<?php

namespace Framework\Router\Dispatcher\Utility;

use PHPUnit_Framework_TestCase;
use Framework\Router\Route\Collection\CollectionInterface;
use Framework\Router\Route\RouteInterface;
use FastRoute\RouteCollector;

class CollectionProcessorTest extends PHPUnit_Framework_TestCase
{
    public function testRoutesAreAddededToCollectorFromCollection()
    {
        $methodsA = ['GET', 'POST'];
        $pathA = '/hello/world';
        $callableA = function () { };

        $methodsB = ['PUT', 'PATCH'];
        $pathB = '/hello/mars';
        $callableB = function () { };

        $routes = [
            $this->getMockRoute($methodsA, $pathA, $callableA),
            $this->getMockRoute($methodsB, $pathB, $callableB)
        ];

        $collection = $this->getMockCollection();
        $collection->expects($this->once())
            ->method('all')
            ->willReturn($routes);

        $collector = $this->getMockCollector();

        $collector->expects($this->exactly(2))
            ->method('addRoute')
            ->withConsecutive(
                [$methodsA, $pathA, $callableA],
                [$methodsB, $pathB, $callableB]
            );

        $instance = new CollectionProcessor($collection);

        $instance($collector);
    }

    protected function getMockCollection()
    {
        return $this->getMockBuilder(CollectionInterface::class)
            ->getMock();
    }

    protected function getMockCollector()
    {
        return $this->getMockBuilder(RouteCollector::class)
            ->disableOriginalConstructor()
            ->getMock();
    }

    protected function getMockRoute($method, $path, $callable)
    {
        $route = $this->getMockBuilder(RouteInterface::class)
            ->getMock();

        $route->expects($this->once())
            ->method('getMethods')
            ->willReturn($method);

        $route->expects($this->once())
            ->method('getPath')
            ->willReturn($path);

        $route->expects($this->once())
            ->method('getCallable')
            ->willReturn($callable);

        return $route;
    }
}
