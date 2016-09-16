<?php

namespace Framework\Handler;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

class NotAllowedHandler implements HandlerInterface
{
    protected $content = <<<BODY
<!DOCTYPE html>
<html>
    <head>
        <title>Method not allowed</title>
    </head>
    <body>
        <header>
            <h1>Method not allowed</h1>
        </header>
        <p>The request you made was invalid.</p>
    </body>
</html>
BODY;

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $response->getBody()->write($this->content);

        return $response;
    }
}
