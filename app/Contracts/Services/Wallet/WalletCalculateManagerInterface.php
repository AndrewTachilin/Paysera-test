<?php

declare(strict_types=1);

namespace App\Contracts\Services\Wallet;

use App\Models\Actions\WalletOperation;
use Illuminate\Support\Collection;

interface WalletCalculateManagerInterface
{
    public function getType(): string;

    public function calculateCommissionFee(
        WalletOperation $walletOperation,
        Collection $userHistories,
        array $exchangeCurrency
    ): string;
}
