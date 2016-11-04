<?php

namespace Framework\Http\Exception;

class NotAllowedException extends HttpException
{
    public function getStatusCode(): int
    {
        return 405;
    }
}
