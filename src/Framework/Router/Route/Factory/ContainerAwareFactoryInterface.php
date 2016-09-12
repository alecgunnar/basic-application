<?php

namespace Framework\Router\Route\Factory;

use Framework\Router\Route\RouteInterface;

interface ContainerAwareFactoryInterface
{
    /**
     * Builds a route from the provided parameters
     *
     * @param string $methods
     * @param string $path
     * @param mixed $callable
     * @param mixed[] $middleware = []
     */
    public function buildRoute(string $methods, string $path, $callable, array $middleware = []): RouteInterface;
}
