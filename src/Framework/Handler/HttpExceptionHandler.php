<?php

namespace Framework\Handler;

use Whoops\Handler\Handler;
use Framework\Http\Exception\HttpExceptionInterface;

class HttpExceptionHandler extends Handler
{
    public function handle()
    {
        $exception = $this->getException();

        if ($exception instanceof HttpExceptionInterface) {
            $this->getRun()->sendHttpCode(
                $exception->getResponse()->getStatusCode()
            );
        }
    }
}
