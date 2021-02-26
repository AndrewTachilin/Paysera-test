<?php

declare(strict_types=1);

namespace App\Exceptions\ParseFile;

use Exception;

class ParseFileException extends Exception
{
    public function __construct(string $message = '')
    {
        parent::__construct($message);
    }
}
