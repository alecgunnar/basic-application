<?php

namespace Maverick\Http\Router\Route\Factory;

use Maverick\Http\Router\Route\RouteInterface;

interface ContainerAwareFactoryInterface
{
    /**
     * Builds a route from the provided parameters
     *
     * @param string|array $methods
     * @param string $path
     * @param mixed $callable
     */
    public function buildRoute($methods, string $path, $callable): RouteInterface;
}
