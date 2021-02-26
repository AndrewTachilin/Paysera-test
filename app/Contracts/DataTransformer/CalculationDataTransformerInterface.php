<?php

declare(strict_types=1);

namespace App\Contracts\DataTransformer;

use App\Contracts\Services\Wallet\WalletCalculateManagerInterface;
use App\Models\Actions\Calculation;
use App\Models\Actions\WalletOperation;
use Illuminate\Support\Collection;

interface CalculationDataTransformerInterface
{
    public function collectDataForCommission(
        Collection $userHistory,
        array $exchangeRates,
        WalletCalculateManagerInterface $walletAction,
        WalletOperation $walletOperation
    ): Calculation;
}
