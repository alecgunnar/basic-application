<?php

namespace Framework\Http\Router\Route\Loader;

use Framework\Http\Router\Route\Collection\CollectionInterface;
use InvalidArgumentException;

interface LoaderInterface
{
    /**
     * Returns the routes loaded from the source
     *
     * @throws InvalidArgumentException
     * @param string $file
     * @param CollectionInterface $collection
     */
    public function loadRoutes(string $file, CollectionInterface $collection);
}
