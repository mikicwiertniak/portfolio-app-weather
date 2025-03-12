<?php

namespace App\Exceptions;

use Exception;
use Throwable;

class WeatherApiException extends Exception
{
    public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        if (empty($message)) {
            $message = "Weather api error";
        }
        parent::__construct($message, $code, $previous);
    }
}
