<?php

namespace Framework\Handler;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

class NotFoundHandler implements HandlerInterface
{
    protected $content = <<<BODY
<!DOCTYPE html>
<html>
    <head>
        <title>Page not found</title>
    </head>
    <body>
        <header>
            <h1>Page not found</h1>
        </header>
        <p>The page you requested does not exist.</p>
    </body>
</html>
BODY;

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $response->getBody()->write($this->content);

        return $response;
    }
}
