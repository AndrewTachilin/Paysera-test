<?php

declare(strict_types=1);

namespace App\Exceptions\UnavailableService;

use Exception;
use Illuminate\Http\JsonResponse;

class UnavailableServiceException extends Exception
{
    public function __construct(string $message = '', int $code = JsonResponse::HTTP_INTERNAL_SERVER_ERROR)
    {
        parent::__construct($message, $code);
    }
}
