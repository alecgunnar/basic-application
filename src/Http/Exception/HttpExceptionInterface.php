<?php

namespace Framework\Http\Exception;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

interface HttpExceptionInterface
{
    /**
     * @return ServerRequestInterface
     */
    public function getServerRequest(): ServerRequestInterface;

    /**
     * @return ResponseInterface
     */
    public function getResponse(): ResponseInterface;
}
