<?php

namespace Framework\Router\Route;

interface RouteInterface
{
    /**
     * Returns the path associated with the route
     *
     * @return string
     */
    public function getPath(): string;

    /**
     * Returns the callable associated with the route
     *
     * @return callable
     */
    public function getCallable(): callable;

    /**
     * Returns the middleware associated with the route
     *
     * @return callable[]
     */
    public function getMiddleware(): array;
}
