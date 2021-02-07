<?php

declare(strict_types=1);

namespace App\Chains\ChainOfCurrencyExchange;

use App\Contracts\Strategies\JpyExchangeInterface;
use App\Services\Wallet\MathOperations;

class JpyStrategy implements JpyExchangeInterface
{
    private MathOperations $mathOperations;

    public function __construct(MathOperations $mathOperations)
    {
        $this->mathOperations = $mathOperations;
    }

    public function getType(): string
    {
        return self::JPY;
    }

    public function exchange(string $currency, float $amount, array $currencyExchangeRates): float
    {
        return $this->mathOperations->convertCurrency($amount, $currencyExchangeRates[$currency]);
    }
}
