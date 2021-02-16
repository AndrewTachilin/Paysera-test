<?php

declare(strict_types=1);

namespace App\Services\CurrencyExchange;

use App\Contracts\Strategies\EuroExchangeInterface;
use App\Services\Wallet\MathOperations;

class CurrencyExchangeService
{
    private MathOperations $mathOperations;

    public function __construct(MathOperations $mathOperations)
    {
        $this->mathOperations = $mathOperations;
    }

    public function exchange(string $currency, float $amount, array $currencyExchangeRates): float
    {
        if ($currency !== EuroExchangeInterface::EURO) {
            $amount = $this->mathOperations->convertCurrency($amount, $currencyExchangeRates[$currency]);
        }

        return $amount;
    }
}
