<?php

declare(strict_types=1);

namespace App\Services\Data;

use App\Contracts\Services\Data\CalculateCommissionInterface;
use App\Models\Actions\Calculation;

class CalculateCommissionService implements CalculateCommissionInterface
{
    public function calculateCommission(Calculation $calculationData): string
    {
        return $calculationData->getWalletAction()->calculateCommissionFee(
            $calculationData->getWalletOperation(),
            $calculationData->getUserHistory(),
            $calculationData->getExchangeRates()
        );
    }
}
