<?php

declare(strict_types=1);

namespace App\Exceptions\Wallet;

use Exception;

class WalletActionException extends Exception
{
    public function __construct(string $message = '')
    {
        parent::__construct($message);
    }
}
