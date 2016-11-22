<?php

namespace Maverick;

use Maverick\Http\Router\RouterInterface;
use Maverick\Http\Exception\NotFoundException;
use Maverick\Http\Exception\NotAllowedException;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Psr7\Response;
use Interop\Container\ContainerInterface;

class Application
{
    /**
     * @var RouterInterface
     */
    protected $router;

    /**
     * @var ServerRequestInterface
     */
    protected $request;

    /**
     * @var ResponseInterface
     */
    protected $response;

    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var ResponseInterface
     */
    protected $sentResponse;

    /**
     * @var string
     */
    const CALLABLE_RETURN_INVALID_FORMAT = 'Route callable did not return an instance of %s.';

    /**
     * @param RouterInterface $router
     */
    public function __construct(
        RouterInterface $router,
        ServerRequestInterface $request,
        ResponseInterface $response,
        ContainerInterface $container
    ) {
        $this->router = $router;
        $this->request = $request;
        $this->response = $response;
        $this->container = $container;
    }

    /**
     * @throws HttpException
     * @throws NotFoundException
     * @throws NotAllowedException
     * @throws UnexpectedValueException
     * @param ServerRequestInterface $request = null
     * @param ResponseInterface $response = null
     * @return ResponseInterface $response
     */
    public function handleRequest(
        ServerRequestInterface $request = null,
        ResponseInterface $response = null
    ): ResponseInterface {
        $request = $request ?? $this->request;
        $response = $response ?? $this->response;

        $status = $this->router->processRequest($request);

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
     * @throws RuntimeException
     * @param ResponseInterface $response
     */
    public function sendResponse(ResponseInterface $response)
    {
        if (($this->sentResponse instanceof ResponseInterface) || headers_sent()) {
            throw new \RuntimeException('A response has already been sent, you cannot send another.');
        }

        echo (string) $response->getBody();

        $this->sentResponse = $response;
    }
}
