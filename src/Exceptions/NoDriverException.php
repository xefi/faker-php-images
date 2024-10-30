<?php

namespace Xefi\Faker\Images\Exceptions;

use Throwable;

class NoDriverException extends \RuntimeException
{
    public function __construct(string $message = '', int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}