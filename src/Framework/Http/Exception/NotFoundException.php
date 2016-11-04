<?php

namespace Framework\Http\Exception;

class NotFoundException extends HttpException
{
    protected function getStatus(): int
    {
        return 404;
    }
}
