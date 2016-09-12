<?php

namespace Framework\Router\Route\Loader;

use PHPUnit_Framework_TestCase;
use Framework\Router\Route\Route;
use Framework\Router\Route\Factory\ContainerAwareFactoryInterface;
use Framework\Router\Route\Collection\CollectionInterface;
use org\bovigo\vfs\vfsStream;

class YamlLoaderTest extends PHPUnit_Framework_TestCase
{
    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage The route configuration file "does-not-exist.yml" does not exist.
     */
    public function testExceptionThrownWhenFileDoesNotExist()
    {
        $collection = $this->getMockCollection();

        $instance = $this->getInstance();
        $instance->loadRoutes('does-not-exist.yml', $collection);
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessageRegExp /The route configuration file ".+" does not contain valid YAML. The error was: .+/
     */
    public function testExceptionThrownWhenFileIsNotValidYaml()
    {
        $collection = $this->getMockCollection();

        $root = vfsStream::setup();
        $file = vfsStream::newFile('invalid-yaml.yml')
            ->withContent('{ a <=> b ')
            ->at($root);

        $instance = $this->getInstance();
        $instance->loadRoutes($file->url(), $collection);
    }

    public function testLoadRoutesBuildsRouteFromConfig()
    {
        $name = 'route.name';
        $methods = 'GET';
        $path = '/welcome';
        $service = 'test';
        $callable = function () { };
        $middleware = [function () { }];

        $config = <<<YAML
- name: $name
  path: $path
  methods: $methods
  callable: test
  middleware:
    - test
YAML;

        $root = vfsStream::setup();
        $file = vfsStream::newFile('routes.yml')
            ->withContent($config)
            ->at($root);

        $route = new Route($methods, $path, $callable, $middleware);

        $collection = $this->getMockCollection();
        $collection->expects($this->once())
            ->method('withRoute')
            ->with($name, $route);

        $factory = $this->getMockFactory();
        $factory->expects($this->once())
            ->method('buildRoute')
            ->with($methods, $path, $service, [$service])
            ->willReturn($route);

        $instance = $this->getInstance($factory);

        $routes = $instance->loadRoutes($file->url(), $collection);
    }

    public function getMockFactory()
    {
        return $this->getMockBuilder(ContainerAwareFactoryInterface::class)
            ->getMock();
    }

    public function getMockCollection()
    {
        return $this->getMockBuilder(CollectionInterface::class)
            ->getMock();
    }

    public function getInstance(ContainerAwareFactoryInterface $factory = null)
    {
        return new YamlLoader($factory ?? $this->getMockFactory());
    }
}
