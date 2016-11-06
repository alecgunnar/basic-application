<?php

namespace Maverick\View;

class NotAllowedView implements ViewInterface
{
    protected $content = <<<BODY
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="Method Not Allowed Not Found</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
        <style>
        .container {
            max-width: 600px;
        }
        </style>
    </head>
    <body>
        <div class="container">
            <header class="page-header"><h1>Method Not Allowed</h1></header>
            <p class="lead">You are not allowed to use this method to access this page.</p>
        </div>
    </body>
</html>
BODY;

    public function render(array $params = []): string
    {
        return $this->content;
    }
}
