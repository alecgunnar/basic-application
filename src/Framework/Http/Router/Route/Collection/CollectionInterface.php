<?php

namespace Framework\Http\Router\Route\Collection;

use Framework\Http\Router\Route\RouteInterface;
use Countable;

interface CollectionInterface extends Countable
{
    /**
     * Adds a new route to the collection
     *
     * @param string $name
     * @param RouteInterface $route
     */
    public function withRoute(string $name, RouteInterface $route);

    /**
     * Adds all of the routes to the collection
     *
     * @param CollectionInterface $routes
     */
    public function withRoutes(CollectionInterface $routes);

    /**
     * Returns an array of all of the routes
     *
     * @return RouteInterface[]
     */
    public function all(): array;

    /**
     * Get the route matching the given name
     *
     * @throws Exception
     * @return RouteInterface
     */
    public function getRoute(string $name): RouteInterface;
}
