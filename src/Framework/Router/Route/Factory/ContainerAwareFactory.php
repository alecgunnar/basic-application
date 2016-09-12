<?php

namespace Framework\Router\Route\Factory;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Framework\Router\Route\RouteInterface;
use Framework\Router\Route\Route;

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
        string $methods,
        string $path,
        $callable,
        array $middleware = []
    ): RouteInterface {
        $callable = $this->loadCallable($callable);
        $middleware = array_map([$this, 'loadCallable'], $middleware);

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
