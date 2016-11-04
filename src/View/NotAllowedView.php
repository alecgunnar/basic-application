<?php

namespace Framework\View;

class NotAllowedView implements ViewInterface
{
    protected $content = <<<BODY
<!DOCTYPE html>
<html>
    <head>
        <title>Not Allowed</title>
    </head>
    <body>
        <header>
            <h1>Not Allowed</h1>
        </header>
        <p>You're not allowed to request this page via this method.</p>
    </body>
</html>
BODY;

    public function render(): string
    {
        return $this->content;
    }
}
