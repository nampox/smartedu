<?php

namespace App\Exceptions;

class UnauthorizedException extends BaseException
{
    protected $statusCode = 401;
    protected $errorCode = 'UNAUTHORIZED';

    public function __construct(string $message = 'Unauthorized access', int $code = 0, ?Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
