<?php

declare(strict_types=1);

namespace App\Exceptions\Currency;

use Exception;

class InvalidCurrencyException extends Exception
{
    public function __construct(string $message = '')
    {
        parent::__construct($message);
    }
}
