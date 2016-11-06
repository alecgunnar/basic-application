<?php

namespace Maverick;

use Maverick\Http\Router\RouterInterface;
use Maverick\Http\Exception\NotFoundException;
use Maverick\Http\Exception\NotAllowedException;
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
     * @var ResponseInterface
     */
    protected $response;

    /**
     * @var ResponseInterface
     */
    protected $sentResponse;

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
    public function __construct(
        RouterInterface $router,
        ServerRequestInterface $request,
        ResponseInterface $response
    ) {
        $this->router = $router;
        $this->request = $request;
        $this->response = $response;
    }

    /**
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
                $msg = sprintf(self::NOT_FOUND_FORMAT, strtoupper($request->getMethod()), $request->getUri()->getPath());
                throw new NotFoundException($msg, $request);
            case RouterInterface::STATUS_NOT_ALLOWED:
                $msg = sprintf(self::NOT_ALLOWED_FORMAT, strtoupper($request->getMethod()));
                throw new NotAllowedException($msg, $request);
            case RouterInterface::STATUS_FOUND:
                $callable = $this->router->getRoute()
                    ->getCallable();
        }

        $response = $callable($request, $response);

        if (!($response instanceof ResponseInterface)) {
            $msg = sprintf(self::CALLABLE_RETURN_INVALID_FORMAT, ResponseInterface::class);
            throw new \Exception($msg);
        }

        return $response;
    }

    /**
     * @throws RuntimeException
     * @param ResponseInterface $response
     */
    public function sendResponse(ResponseInterface $response)
    {
        if ($this->sentResponse instanceof ResponseInterface) {
            throw new \RuntimeException('A response has already been sent, you cannot send another.');
        }

        echo (string) $response->getBody();

        $this->sentResponse = $response;
    }
}
