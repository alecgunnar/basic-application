<?php

namespace Maverick\Http\Exception;

class NotAllowedException extends HttpException
{
    public function getStatusCode(): int
    {
        return 405;
    }
}
