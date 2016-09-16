<?php

namespace Framework;

use Framework\Router\RouterInterface;
use Framework\Handler\HandlerInterface;
use Framework\Handler\GracefulErrorHandler;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Psr7\Response;

class Application
{
    /**
     * @var RouterInterface
     */
    protected $router;

    /**
     * @var callable
     */
    protected $notFoundHandler;

    /**
     * @var callable
     */
    protected $notAllowedHandler;

    /**
     * @var callable
     */
    protected $genericErrorHandler;

    /**
     * @param RouterInterface $router
     */
    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    /**
     * @param HandlerInterface $handler
     */
    public function setNotFoundHandler(HandlerInterface $handler)
    {
        $this->notFoundHandler = $handler;
    }

    /**
     * @param HandlerInterface $handler
     */
    public function setNotAllowedHandler(HandlerInterface $handler)
    {
        $this->notAllowedHandler = $handler;
    }

    /**
     * @param HandlerInterface $handler
     */
    public function setGenericErrorHandler(HandlerInterface $handler)
    {
        $this->genericErrorHandler = $handler;
    }

    /**
     * @param ServerRequestInterface $request
     * @return ResponseInterface $response
     */
    public function handleRequest(ServerRequestInterface $request): ResponseInterface
    {
        $status = $this->router->processRequest($request);

        switch ($status) {
            case RouterInterface::STATUS_FOUND:
                $callable = $this->router->getRoute()->getCallable();
                break;
            case RouterInterface::STATUS_NOT_FOUND:
                $callable = $this->tryHandler($this->notFoundHandler);
                break;
            case RouterInterface::STATUS_NOT_ALLOWED:
                $callable = $this->tryHandler($this->notAllowedHandler);
                break;
            default:
                $callable = $this->tryHandler($this->genericErrorHandler);
        }

        $response = $callable($request, new Response());

        if (!($response instanceof ResponseInterface)) {
            throw new \Exception(
                sprintf('Route callable did not return an instance of %s.', ResponseInterface::class)
            );
        }

        return $response;
    }

    /**
     * @param ResponseInterface $response
     */
    public function sendResponse(ResponseInterface $response)
    {
        echo (string) $response->getBody();
    }

    protected function tryHandler($handler): callable
    {
        if (is_callable($handler)) {
            return $handler;
        }

        return new GracefulErrorHandler();
    }
}
