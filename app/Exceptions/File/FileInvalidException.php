<?php

declare(strict_types=1);

namespace App\Exceptions\File;

use Exception;

class FileInvalidException extends Exception
{
    public function __construct(string $message = '')
    {
        parent::__construct($message);
    }
}
