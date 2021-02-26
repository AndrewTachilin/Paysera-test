<?php

declare(strict_types=1);

namespace App\Contracts\Strategies;

interface CurrencyExchangeStrategyInterface
{
    public function exchange(string $currency, string $amount, array $currencyExchangeRate): string;
}
