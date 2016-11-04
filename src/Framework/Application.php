<?php

namespace Framework;

use Framework\Http\Router\RouterInterface;
use Framework\Http\Router\Exception\NotFoundException;
use Framework\Http\Router\Exception\NotAllowedException;
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
     * @var ServerRequestInterface
     */
    protected $request;

    /**
     * @var string
     */
    const NOT_FOUND_FORMAT = 'A route does not exist for "%s %s".';

    /**
     * @var string
     */
    const NOT_ALLOWED_FORMAT = 'You are not allowed to make this request via %s.';

    /**
     * @var string
     */
    const CALLABLE_RETURN_INVALID_FORMAT = 'Route callable did not return an instance of %s.';

    /**
     * @param RouterInterface $router
     */
    public function __construct(RouterInterface $router, ServerRequestInterface $request)
    {
        $this->router = $router;
        $this->request = $request;
    }

    /**
     * @param ServerRequestInterface $request = null
     * @return ResponseInterface $response
     */
    public function handleRequest(ServerRequestInterface $request = null): ResponseInterface
    {
        $request = $request ?? $this->request;
        $status = $this->router->processRequest($request);

        switch ($status) {
            case RouterInterface::STATUS_NOT_FOUND:
                $msg = sprintf(self::NOT_FOUND_FORMAT, strtoupper($request->getMethod()), $request->getUri()->getPath());
                throw new NotFoundException($msg);
            case RouterInterface::STATUS_NOT_ALLOWED:
                $msg = sprintf(self::NOT_ALLOWED_FORMAT, strtoupper($request->getMethod()));
                throw new NotAllowedException($msg);
            case RouterInterface::STATUS_FOUND:
                $callable = $this->router->getRoute()
                    ->getCallable();
        }

        $response = $callable($request, new Response());

        if (!($response instanceof ResponseInterface)) {
            $msg = sprintf(self::CALLABLE_RETURN_INVALID_FORMAT, ResponseInterface::class);
            throw new \Exception($msg);
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
}
