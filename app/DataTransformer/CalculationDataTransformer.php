<?php

declare(strict_types=1);

namespace App\DataTransformer;

use App\Contracts\DataTransformer\CalculationDataTransformerInterface;
use App\Contracts\Services\Wallet\WalletCalculateManagerInterface;
use App\Models\Actions\Calculation;
use App\Models\Actions\WalletOperation;
use Illuminate\Support\Collection;

class CalculationDataTransformer implements CalculationDataTransformerInterface
{
    public function collectDataForCommission(
        Collection $userHistory,
        array $exchangeRates,
        WalletCalculateManagerInterface $walletAction,
        WalletOperation $walletOperation
    ): Calculation {
        return (new Calculation())
            ->setUserHistory($userHistory)
            ->setExchangeRates($exchangeRates)
            ->setWalletAction($walletAction)
            ->setWalletOperation($walletOperation);
    }
}
