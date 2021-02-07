<?php

declare(strict_types=1);

namespace App\Contracts\Services\WithdrawRules;

use App\Models\Actions\WalletOperation;
use Illuminate\Support\Collection;

interface ClientTypeInterface
{
    public function detectClientType(Collection $userHistories, WalletOperation $walletOperation): string;

    public function getType(): string;
}
