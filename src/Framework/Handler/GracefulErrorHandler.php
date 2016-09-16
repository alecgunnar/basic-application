<?php

namespace Framework\Handler;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

class GracefulErrorHandler implements HandlerInterface
{
    protected $content = <<<BODY
<!DOCTYPE html>
<html>
    <head>
        <title>There was an error</title>
    </head>
    <body>
        <header>
            <h1>There was an error</h1>
        </header>
        <p>There was an error, your request cannot be completed.</p>
    </body>
</html>
BODY;

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $response->getBody()->write($this->content);

        return $response;
    }
}
