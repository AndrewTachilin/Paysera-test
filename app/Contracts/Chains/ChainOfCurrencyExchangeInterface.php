<?php

declare(strict_types=1);

namespace App\Contracts\Chains;

interface ChainOfCurrencyExchangeInterface
{
    public function exchange(string $currency, float $amount): float;
}
