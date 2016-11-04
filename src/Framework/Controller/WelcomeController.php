<?php

namespace Framework\Controller;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

class WelcomeController
{
    protected $content = <<<BODY
<!DOCTYPE html>
<html>
    <head>
        <title>It works!</title>
    </head>
    <body>
        <header>
            <h1>It works!</h1>
        </header>
        <p>The website is running!</p>
    </body>
</html>
BODY;

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $response->getBody()
            ->write($this->content);

        return $response;
    }
}
