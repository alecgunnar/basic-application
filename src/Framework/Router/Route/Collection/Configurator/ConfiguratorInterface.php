<?php

namespace Framework\Router\Route\Collection\Configurator;

use Framework\Router\Route\Collection\CollectionInterface;

interface ConfiguratorInterface
{
    /**
     * Loads routes into the given route collection
     *
     * @param CollectionInterface $collection
     */
    public function loadRoutes(CollectionInterface $collection);
}
