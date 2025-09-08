<?php

namespace App\Exceptions;

use Illuminate\Validation\ValidationException as LaravelValidationException;

class ValidationException extends BaseException
{
    protected $statusCode = 422;
    protected $errorCode = 'VALIDATION_ERROR';

    public function __construct(string $message = 'Validation failed', int $code = 0, ?Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    /**
     * Create from Laravel validation exception
     */
    public static function fromLaravelValidation(LaravelValidationException $exception): self
    {
        $instance = new self('Validation failed');
        $instance->statusCode = 422;
        $instance->errorCode = 'VALIDATION_ERROR';
        
        return $instance;
    }
}
