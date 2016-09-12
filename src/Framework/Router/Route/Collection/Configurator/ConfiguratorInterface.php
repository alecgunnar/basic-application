<?php

namespace Framework\Router\Route\Collection\Configurator;

use Framework\Router\Route\Collection\CollectionInterface;

interface ConfiguratorInterface
{
    /**
     * Configures the collection with the routes
     *
     * @param CollectionInterface $collection
     */
    public function configure(CollectionInterface $collection);
}
