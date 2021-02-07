<?php

declare(strict_types=1);

namespace App\Chains\ChainOfCurrencyExchange;

use App\Contracts\Strategies\UsdExchangeInterface;
use App\Services\Wallet\MathOperations;

class UsdStrategy implements UsdExchangeInterface
{
    private MathOperations $mathOperations;

    public function __construct(MathOperations $mathOperations)
    {
        $this->mathOperations = $mathOperations;
    }

    public function getType(): string
    {
        return self::USD;
    }

    public function exchange(string $currency, float $amount, array $currencyExchangeRates): float
    {
        return $this->mathOperations->convertCurrency($amount, $currencyExchangeRates[$currency]);
    }
}
