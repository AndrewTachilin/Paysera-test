<?php

declare(strict_types=1);

namespace App\Chains\ChainOfCurrencyExchange;

use App\Contracts\Strategies\EuroExchangeInterface;
use App\Services\Wallet\MathOperations;

class EuroStrategy implements EuroExchangeInterface
{
    private MathOperations $mathOperations;

    public function __construct(MathOperations $mathOperations)
    {
        $this->mathOperations = $mathOperations;
    }

    public function getType(): string
    {
        return self::EURO;
    }

    public function exchange(string $currency, float $amount, array $currencyExchangeRates): float
    {
        return $amount;
    }
}
