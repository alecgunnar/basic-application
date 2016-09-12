<?php

namespace Framework\Router\Route\Collection\Configurator;

use Framework\Router\Route\Loader\LoaderInterface;
use Framework\Router\Route\Collection\CollectionInterface;

class Configurator implements ConfiguratorInterface
{
    /**
     * @var LoaderInterface
     */
    protected $loader;

    /**
     * @var string
     */
    protected $file;

    /**
     * @param LoaderInterface $loader
     * @param string $file
     */
    public function __construct(LoaderInterface $loader, string $file)
    {
        $this->loader = $loader;
        $this->file = $file;
    }

    public function configure(CollectionInterface $collection)
    {
        $this->loader->loadRoutes($this->file, $collection);
    }
}
