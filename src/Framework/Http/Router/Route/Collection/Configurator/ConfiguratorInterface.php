<?php

namespace Framework\Http\Router\Route\Collection\Configurator;

use Framework\Http\Router\Route\Collection\CollectionInterface;

interface ConfiguratorInterface
{
    /**
     * Configures the collection with the routes
     *
     * @param CollectionInterface $collection
     */
    public function configure(CollectionInterface $collection);
}
