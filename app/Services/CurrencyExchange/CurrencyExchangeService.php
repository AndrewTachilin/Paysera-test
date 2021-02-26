<?php

declare(strict_types=1);

namespace App\Services\CurrencyExchange;

use App\Contracts\Strategies\CurrencyExchangeStrategyInterface;
use App\Services\Wallet\MathOperations;

class CurrencyExchangeService implements CurrencyExchangeStrategyInterface
{
    private MathOperations $mathOperations;

    public function __construct(MathOperations $mathOperations)
    {
        $this->mathOperations = $mathOperations;
    }

    public function exchange(string $currency, string $amount, array $currencyExchangeRates): string
    {
        $defaultCurrency = config('app.currencies.default_currency');
        if ($currency !== $defaultCurrency) {
            $amount = $this->mathOperations->convertCurrency($amount, (string) $currencyExchangeRates[$currency]);
        }

        return $amount;
    }
}
