<?php

namespace Framework\Router\Route\Collection\Configurator;

use Symfony\Component\Finder\Finder;

class YamlRouteConfigConfigurator implements ConfiguratorInterface
{
    /**
     * @var Finder
     */
    protected $finder;

    /**
     * @var string
     */
    protected $path;

    public function __construct(Finder $finder, string $path)
    {
        $this->finder = $finder;
        $this->path = $path;
    }

    public function loadRoutes(CollectionInterface $collection)
    {
        
    }
}
