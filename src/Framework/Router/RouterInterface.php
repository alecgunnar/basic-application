<?php

namespace Framework\Router;

use Psr\Http\Message\ServerRequestInterface;
use Framework\Router\Route\RouteInterface;

interface RouterInterface
{
    /**
     * @var int
     */
    const STATUS_FOUND = 200;

    /**
     * @var int
     */
    const STATUS_NOT_FOUND = 404;

    /**
     * @var int
     */
    const STATUS_NOT_ALLOWED = 405;

    /**
     * Process the given request and return the status
     * of the routing attempt
     *
     * @param ServerRequestInterface $request
     * @return int
     */
    public function processRequest(ServerRequestInterface $request): int;

    /**
     * Get the most recently matched route
     *
     * @return RouteInterface
     */
    public function getRoute(): RouteInterface;

    /**
     * Get the methods allowed by the matched route
     *
     * @return string[]
     */
    public function getAllowedMethods(): array;

    /**
     * Get the variables pulled from the URI
     *
     * @return string[]
     */
    public function getUriVars(): array;
}
