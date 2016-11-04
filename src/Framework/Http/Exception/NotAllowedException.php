<?php

namespace Framework\Http\Exception;

class NotAllowedException extends HttpException
{
    protected function getStatus(): int
    {
        return 405;
    }
}
