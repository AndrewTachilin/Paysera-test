<?php

declare(strict_types=1);

namespace App\Services\CurrencyExchange;

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
        $defaultCurrency = config('app.default_currency');
        if ($currency !== $defaultCurrency) {
            $amount = $this->mathOperations->convertCurrency($amount, $currencyExchangeRates[$currency]);
        }

        return $amount;
    }
}
