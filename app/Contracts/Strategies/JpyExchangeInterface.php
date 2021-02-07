<?php

declare(strict_types=1);

namespace App\Contracts\Strategies;

interface JpyExchangeInterface extends CurrencyExchangeStrategyInterface
{
    public const JPY = 'JPY';
}
