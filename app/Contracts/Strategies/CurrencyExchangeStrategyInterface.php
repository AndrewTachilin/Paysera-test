<?php

declare(strict_types=1);

namespace App\Contracts\Strategies;

interface CurrencyExchangeStrategyInterface
{
    public function exchange(string $currency, float $amount, array $currencyExchangeRate): float;

    public function getType();
}
