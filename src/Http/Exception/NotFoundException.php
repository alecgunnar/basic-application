<?php

namespace Framework\Http\Exception;

class NotFoundException extends HttpException
{
    public function getStatusCode(): int
    {
        return 404;
    }
}
