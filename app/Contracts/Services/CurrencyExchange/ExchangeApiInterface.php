<?php

declare(strict_types=1);

namespace App\Contracts\Services\CurrencyExchange;

interface ExchangeApiInterface
{
    public function getRates(): array;
}
