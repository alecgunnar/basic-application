<?php

namespace Framework\Http\Exception;

use RuntimeException;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

abstract class HttpException extends RuntimeException implements HttpExceptionInterface
{
    /**
     * @var ServerRequestInterface
     */
    private $request;

    /**
     * @var ResponseInterface
     */
    private $response;

    public function __construct(string $message, ServerRequestInterface $request, ResponseInterface $response)
    {
        parent::__construct($message);

        $this->request = $request;
        $this->response = $response->withStatus($this->getStatus());
    }

    public function getServerRequest(): ServerRequestInterface
    {
        return $this->request;
    }

    public function getResponse(): ResponseInterface
    {
        return $this->response;
    }

    /**
     * @return int
     */
    abstract protected function getStatus(): int;
}
