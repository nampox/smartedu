<?php

namespace App\Exceptions;

class UserNotFoundException extends BaseException
{
    protected $statusCode = 404;
    protected $errorCode = 'USER_NOT_FOUND';

    public function __construct(string $message = 'User not found', int $code = 0, ?Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
