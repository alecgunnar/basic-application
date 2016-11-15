<?php

namespace Maverick\Http\Router\Route\Factory;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Maverick\Http\Router\Route\RouteInterface;
use Maverick\Http\Router\Route\Route;

class ContainerAwareFactory implements ContainerAwareFactoryInterface
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function buildRoute($methods, string $path, $callable): RouteInterface {
        $callable = $this->loadCallable($callable);

        if (!is_array($methods)) {
            $methods = [$methods];
        }

        return new Route($methods, $path, $callable);
    }

    protected function loadCallable($callable)
    {
        if (!is_callable($callable)) {
            $callable = $this->container->get($callable);
        }

        return $callable;
    }
}
