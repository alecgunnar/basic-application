<?php

namespace Framework\View;

class FatalErrorView implements ViewInterface
{
    protected $content = <<<BODY
<!DOCTYPE html>
<html>
    <head>
        <title>Fatal Error</title>
    </head>
    <body>
        <header>
            <h1>Fatal Error</h1>
        </header>
        <p>There was an error, we cannot continue.</p>
    </body>
</html>
BODY;

    public function render(): string
    {
        return $this->content;
    }
}
