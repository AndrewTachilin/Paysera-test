<?php

declare(strict_types=1);

namespace App\Contracts\Strategies;

interface EuroExchangeInterface extends CurrencyExchangeStrategyInterface
{
    public const EURO = 'EUR';
}
