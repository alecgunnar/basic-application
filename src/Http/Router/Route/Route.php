<?php

namespace Maverick\Http\Router\Route;

use InvalidArgumentException;

class Route implements RouteInterface
{
    /**
     * @var string[]
     */
    protected $methods;

    /**
     * @var string
     */
    protected $path;

    /**
     * @var callable
     */
    protected $callable;

    /**
     * @var callable[]
     */
    protected $middleware;

    /**
     * @throws InvalidArgumentException
     * @param string[] $methods
     * @param string $path
     * @param callable $callable
     * @param callable[] $middleware = []
     */
    public function __construct(
        array $methods,
        string $path,
        callable $callable,
        array $middleware = []
    ) {
        $this->methods = $methods;
        $this->path = $path;
        $this->callable = $callable;
        $this->middleware = $middleware;

        $this->verifyMiddlware();
    }

    public function getMethods(): array
    {
        return $this->methods;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getCallable(): callable
    {
        return $this->callable;
    }

    public function getMiddleware(): array
    {
        return $this->middleware;
    }

    protected function verifyMiddlware()
    {
        foreach ($this->middleware as $middleware) {
            if (!is_callable($middleware)) {
                throw new InvalidArgumentException('All middleware supplied for the route must be callable.');
            }
        }
    }
}
