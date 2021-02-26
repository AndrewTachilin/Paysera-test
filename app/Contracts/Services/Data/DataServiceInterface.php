<?php

declare(strict_types=1);

namespace App\Contracts\Services\Data;

use App\Models\Actions\Calculation;

interface DataServiceInterface
{
    public function prepareDataForCalculation(array $walletOperation, array $exchangeRates): Calculation;
}
