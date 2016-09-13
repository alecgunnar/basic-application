<?php

namespace Framework\Router\Route\Factory;

use Framework\Router\Route\RouteInterface;

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
