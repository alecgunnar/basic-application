<?php

namespace Framework\Router\Route\Collection;

use Framework\Router\Route\RouteInterface;
use Countable;

interface CollectionInterface extends Countable
{
    /**
     * Adds a new route to the collection
     *
     * Returns a new collection instance with
     * the new route added.
     *
     * @param string $name
     * @param RouteInterface $route
     * @return CollectionInterface
     */
    public function withRoute(string $name, RouteInterface $route): CollectionInterface;

    /**
     * Adds all of the routes to the collection
     *
     * Returns a new collection instance with
     * the new routes added.
     *
     * @param RouteInterface[] $routes
     * @return CollectionInterface
     */
    public function withRoutes(array $routes): CollectionInterface;

    /**
     * Returns an array of all of the routes
     *
     * @return RouteInterface[]
     */
    public function all(): array;
}
