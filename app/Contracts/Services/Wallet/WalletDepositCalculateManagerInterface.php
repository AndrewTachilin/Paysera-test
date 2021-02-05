<?php

declare(strict_types=1);

namespace App\Contracts\Services\Wallet;

interface WalletDepositCalculateManagerInterface extends WalletCalculateManagerInterface
{
    public const ACTION = 'deposit';
}
