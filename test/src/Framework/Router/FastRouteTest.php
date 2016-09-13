<?php

namespace Framework\Router;

use PHPUnit_Framework_TestCase;
use FastRoute\Dispatcher;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UriInterface;
use Framework\Router\Route\RouteInterface;

class FastRouteTest extends PHPUnit_Framework_TestCase
{
    public function testMatchingRouteFoundReturnsFound()
    {
        $method = 'GET';
        $uri = 'http://world.com/hello/world';

        $dispatcher = $this->getMockDispatcher();
        $dispatcher->expects($this->once())
                ->method('dispatch')
                ->with($method, $uri)
                ->willReturn([Dispatcher::FOUND, function() { }, []]);

        $request = $this->getMockRequest($method, $uri);

        $instance = new FastRoute($dispatcher);

        $this->assertEquals(RouterInterface::STATUS_FOUND, $instance->processRequest($request));
    }

    public function testNotMatchingRouteMethodFoundReturnsNotAllowed()
    {
        $method = 'GET';
        $uri = 'http://world.com/hello/world';

        $dispatcher = $this->getMockDispatcher();
        $dispatcher->expects($this->once())
                ->method('dispatch')
                ->with($method, $uri)
                ->willReturn([Dispatcher::METHOD_NOT_ALLOWED, ['POST']]);

        $request = $this->getMockRequest($method, $uri);

        $instance = new FastRoute($dispatcher);

        $this->assertEquals(RouterInterface::STATUS_NOT_ALLOWED, $instance->processRequest($request));
    }

    public function testNoRouteFoundReturnsNotFound()
    {
        $method = 'GET';
        $uri = 'http://world.com/hello/world';

        $dispatcher = $this->getMockDispatcher();
        $dispatcher->expects($this->once())
                ->method('dispatch')
                ->with($method, $uri)
                ->willReturn([Dispatcher::NOT_FOUND]);

        $request = $this->getMockRequest($method, $uri);

        $instance = new FastRoute($dispatcher);

        $this->assertEquals(RouterInterface::STATUS_NOT_FOUND, $instance->processRequest($request));
    }

    public function testGetRouteReturnsMatchedRoute()
    {
        $method = 'GET';
        $uri = 'http://world.com/hello/world';
        $route = $this->getMockRoute();

        $dispatcher = $this->getMockDispatcher();
        $dispatcher->expects($this->once())
                ->method('dispatch')
                ->with($method, $uri)
                ->willReturn([Dispatcher::FOUND, $route, []]);

        $request = $this->getMockRequest($method, $uri);

        $instance = new FastRoute($dispatcher);
        $instance->processRequest($request);

        $this->assertSame($route, $instance->getRoute());
    }

    public function testGetUriVarsReturnsVarsFromMatchedUri()
    {
        $method = 'GET';
        $uri = 'http://world.com/hello/world';
        $route = $this->getMockRoute();
        $vars = ['hello' => 'world', 'from' => 'mars'];

        $dispatcher = $this->getMockDispatcher();
        $dispatcher->expects($this->once())
                ->method('dispatch')
                ->with($method, $uri)
                ->willReturn([Dispatcher::FOUND, $route, $vars]);

        $request = $this->getMockRequest($method, $uri);

        $instance = new FastRoute($dispatcher);
        $instance->processRequest($request);

        $this->assertEquals($vars, $instance->getUriVars());
    }

    public function testGetAllowedMethodsReturnsMethodsAllowedByMatchedRoute()
    {
        $method = 'GET';
        $uri = 'http://world.com/hello/world';
        $methods = ['POST', 'PUT'];

        $dispatcher = $this->getMockDispatcher();
        $dispatcher->expects($this->once())
                ->method('dispatch')
                ->with($method, $uri)
                ->willReturn([Dispatcher::METHOD_NOT_ALLOWED, $methods]);

        $request = $this->getMockRequest($method, $uri);

        $instance = new FastRoute($dispatcher);
        $instance->processRequest($request);

        $this->assertEquals($methods, $instance->getAllowedMethods());
    }

    public function testNotFoundIsReturnedByDefault()
    {
        $method = 'GET';
        $uri = 'http://world.com/hello/world';

        $dispatcher = $this->getMockDispatcher();
        $dispatcher->expects($this->once())
                ->method('dispatch')
                ->with($method, $uri)
                ->willReturn([4]);

        $request = $this->getMockRequest($method, $uri);

        $instance = new FastRoute($dispatcher);

        $this->assertEquals(RouterInterface::STATUS_NOT_FOUND, $instance->processRequest($request));
    }

    protected function getMockDispatcher()
    {
        return $this->getMockBuilder(Dispatcher::class)
            ->getMock();
    }

    protected function getMockRequest($method, $uri)
    {
        $request = $this->getMockBuilder(ServerRequestInterface::class)
            ->getMock();

        $request->expects($this->once())
            ->method('getMethod')
            ->willReturn($method);

        $request->expects($this->once())
            ->method('getUri')
            ->willReturn($this->getMockUri($uri));

        return $request;
    }

    protected function getMockUri($uri)
    {
        $mock = $this->getMockBuilder(UriInterface::class)
            ->getMock();

        $mock->expects($this->once())
            ->method('__toString')
            ->willReturn($uri);

        return $mock;
    }

    protected function getMockRoute()
    {
        return $this->getMockBuilder(RouteInterface::class)
            ->getMock();
    }
}
