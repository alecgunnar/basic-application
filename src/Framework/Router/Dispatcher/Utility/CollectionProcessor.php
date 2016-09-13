<?php

namespace Framework\Router\Dispatcher\Utility;

use Framework\Router\Route\Collection\CollectionInterface;
use FastRoute\RouteCollector;

class CollectionProcessor
{
    /**
     * @var CollectionInterface
     */
    protected $collection;

    /**
     * @param CollectionInterface $collection
     */
    public function __construct(CollectionInterface $collection)
    {
        $this->collection = $collection;
    }

    public function __invoke(RouteCollector $router)
    {
        foreach ($this->collection->all() as $route) {
            $router->addRoute(
                $route->getMethods(),
                $route->getPath(),
                $route->getCallable()
            );
        }
    }
}
