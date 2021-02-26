<?php

declare(strict_types=1);

namespace App\Exceptions\DataTransformer;

use Exception;

class UnableToTransformDataException extends Exception
{
    public function __construct(string $message = '')
    {
        parent::__construct($message);
    }
}
