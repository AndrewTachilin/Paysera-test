<?php

declare(strict_types=1);

namespace App\Contracts\Services\WithdrawRules;

use App\Models\Actions\WalletOperation;
use Illuminate\Support\Collection;

interface ClientTypeInterface
{
    public function calculateCommission(
        Collection $userHistories,
        WalletOperation $walletOperation,
        array $exchangeCurrency
    ): string;

    public function getType(): string;
}
