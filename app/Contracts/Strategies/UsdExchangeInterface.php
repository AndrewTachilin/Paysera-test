<?php

declare(strict_types=1);

namespace App\Contracts\Strategies;

interface UsdExchangeInterface extends CurrencyExchangeStrategyInterface
{
    public const USD = 'USD';
}
