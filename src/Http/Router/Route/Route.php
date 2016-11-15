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
     * @throws InvalidArgumentException
     * @param string[] $methods
     * @param string $path
     * @param callable $callable
     */
    public function __construct(
        array $methods,
        string $path,
        callable $callable
    ) {
        $this->methods = $methods;
        $this->path = $path;
        $this->callable = $callable;
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
}
