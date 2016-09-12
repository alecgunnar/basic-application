<?php

namespace Framework\Router\Route\Collection;

use Framework\Router\Route\RouteInterface;

class Collection implements CollectionInterface
{
    /**
     * @var RouteInterface[]
     */
    protected $routes = [];

    public function withRoute(string $name, RouteInterface $route)
    {
        $this->routes[$name] = $route;
    }

    public function withRoutes(CollectionInterface $routes)
    {
        $this->routes = array_merge($this->routes, $routes->all());
    }

    public function all(): array
    {
        return $this->routes;
    }

    public function count(): int
    {
        return count($this->routes);
    }
}
