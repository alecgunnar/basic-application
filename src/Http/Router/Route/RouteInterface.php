<?php

namespace Maverick\Http\Router\Route;

interface RouteInterface
{
    /**
     * Returns the methods associated with this route
     *
     * @return array
     */
    public function getMethods(): array;

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
}
