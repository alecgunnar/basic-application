<?php

namespace Framework\View;

class NotFoundView implements ViewInterface
{
    protected $content = <<<BODY
<!DOCTYPE html>
<html>
    <head>
        <title>Not Found</title>
    </head>
    <body>
        <header>
            <h1>Not Found</h1>
        </header>
        <p>The page was not found.</p>
    </body>
</html>
BODY;

    public function render(): string
    {
        return $this->content;
    }
}
