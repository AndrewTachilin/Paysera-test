<?php

declare(strict_types=1);

namespace App\Exceptions\ValidationException;

use Exception;

class ClientTypeException extends Exception
{
    public function __construct(string $message = '')
    {
        parent::__construct($message);
    }
}
