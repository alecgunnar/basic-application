<?php

namespace Maverick;

use Maverick\Http\Router\RouterInterface;
use Maverick\Http\Exception\NotFoundException;
use Maverick\Http\Exception\NotAllowedException;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Interop\Container\ContainerInterface;

class Application
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var string
     */
    const CALLABLE_RETURN_INVALID_FORMAT = 'Route callable did not return an instance of %s.';

    /**
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @param ServerRequestInterface $request = null
     *
     * @throws HttpException
     * @throws NotFoundException
     * @throws NotAllowedException
     * @throws UnexpectedValueException
     *
     * @return ResponseInterface $response
     */
    public function handleRequest(ServerRequestInterface $request = null): ResponseInterface
    {
        $request = $request ?? $this->container->get('server_request');
        $router = $this->container->get('router');
        $status = $router->processRequest($request);

        switch ($status) {
            case RouterInterface::STATUS_NOT_FOUND:
                throw new NotFoundException($request);
            case RouterInterface::STATUS_NOT_ALLOWED:
                throw new NotAllowedException($request);
            case RouterInterface::STATUS_FOUND:
                $route = $this->router->getRoute();
        }

        $callable = $this->container->get($route->getService());
        $response = $callable($request);

        if (!($response instanceof ResponseInterface)) {
            $msg = sprintf(self::CALLABLE_RETURN_INVALID_FORMAT, ResponseInterface::class);
            throw new \UnexpectedValueException($msg);
        }

        return $response;
    }

    /**
     * @param ResponseInterface $response
     * @throws RuntimeException
     */
    public function sendResponse(ResponseInterface $response)
    {
        if (headers_sent()) {
            throw new \RuntimeException('A response has already been sent, you cannot send another.');
        }

        echo (string) $response->getBody();
    }
}
