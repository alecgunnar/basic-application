<?php

namespace Framework\Http\Router\Route\Factory;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Framework\Http\Router\Route\RouteInterface;
use Framework\Http\Router\Route\Route;

class ContainerAwareFactory implements ContainerAwareFactoryInterface
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function buildRoute(
        $methods,
        string $path,
        $callable,
        array $middleware = []
    ): RouteInterface {
        $callable = $this->loadCallable($callable);
        $middleware = array_map([$this, 'loadCallable'], $middleware);

        if (!is_array($methods)) {
            $methods = [$methods];
        }

        return new Route($methods, $path, $callable, $middleware);
    }

    protected function loadCallable($callable)
    {
        if (!is_callable($callable)) {
            $callable = $this->container->get($callable);
        }

        return $callable;
    }
}
