<?php

namespace Framework\View;

class NotFoundView implements ViewInterface
{
    protected $content = <<<BODY
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Page Not Found</title>
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
            <header class="page-header"><h1>Page Not Found</h1></header>
            <p class="lead">The page you are looking for was not found.</p>
        </div>
    </body>
</html>
BODY;

    public function render(): string
    {
        return $this->content;
    }
}
