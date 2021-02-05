<?php

declare(strict_types=1);

namespace App\Contracts\Services\Wallet;

interface WalletWithdrawCalculateManagerInterface extends WalletCalculateManagerInterface
{
    public const ACTION = 'withdraw';
}
