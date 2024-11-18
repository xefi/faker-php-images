<?php

namespace Xefi\Faker\Images\Exceptions;

use Throwable;

class NoImageDriverException extends \RuntimeException
{
    public function __construct(string $message = '', int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}