<?php

namespace Framework\Router;

use Psr\Http\Message\ServerRequestInterface;
use Framework\Router\Route\Collection\CollectionInterface;
use Framework\Router\Route\RouteInterface;
use FastRoute\Dispatcher;

class FastRoute implements RouterInterface
{
    /**
     * @var Dispatcher
     */
    protected $dispatcher;

    /**
     * @var CollectionInterface
     */
    protected $collection;

    /**
     * @var RouteInterface
     */
    protected $route;

    /**
     * @var string[]
     */
    protected $vars;

    /**
     * @var string[]
     */
    protected $allowed;

    /**
     * @param Dispatcher $dispatcher
     * @param CollectionInterface $collection
     */
    public function __construct(Dispatcher $dispatcher, CollectionInterface $collection)
    {
        $this->dispatcher = $dispatcher;
        $this->collection = $collection;
    }

    public function processRequest(ServerRequestInterface $request): int
    {
        $ret = $this->dispatcher->dispatch(
            $request->getMethod(),
            $request->getUri()->getPath()
        );

        switch ($ret[0]) {
            case Dispatcher::FOUND:
                $this->route = $this->collection->getRoute($ret[1]);
                $this->vars = $ret[2];
                return RouterInterface::STATUS_FOUND;
            case Dispatcher::METHOD_NOT_ALLOWED:
                $this->allowed = $ret[1];
                return RouterInterface::STATUS_NOT_ALLOWED;
            default:
                return RouterInterface::STATUS_NOT_FOUND;
        }
    }

    public function getRoute(): RouteInterface
    {
        return $this->route;
    }

    public function getAllowedMethods(): array
    {
        return $this->allowed;
    }

    public function getUriVars(): array
    {
        return $this->vars;
    }
}
