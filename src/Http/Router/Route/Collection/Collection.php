<?php

namespace Maverick\Http\Router\Route\Collection;

use Maverick\Http\Router\Route\RouteInterface;
use RuntimeException;

class Collection implements CollectionInterface
{
    /**
     * @var RouteInterface[]
     */
    protected $routes = [];

    /**
     * @var string
     */
    const INVALID_ROUTE_EXCEPTION = 'A route named "%s" does not exist.';

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

    public function getRoute(string $name): RouteInterface
    {
        if (isset($this->routes[$name])) {
            return $this->routes[$name];
        }

        throw new RuntimeException(
            sprintf(self::INVALID_ROUTE_EXCEPTION, $name)
        );
    }
}
