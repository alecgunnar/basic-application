<?php

namespace Framework\Http\Router\Route\Factory;

use Framework\Http\Router\Route\RouteInterface;

interface ContainerAwareFactoryInterface
{
    /**
     * Builds a route from the provided parameters
     *
     * @param string|array $methods
     * @param string $path
     * @param mixed $callable
     * @param mixed[] $middleware = []
     */
    public function buildRoute($methods, string $path, $callable, array $middleware = []): RouteInterface;
}
