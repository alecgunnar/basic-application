<?php

namespace Framework\View;

class WelcomeView implements ViewInterface
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

    public function render(): string
    {
        return $this->content;
    }
}
