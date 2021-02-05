<?php

declare(strict_types=1);

namespace App\Chains\ChainOfCurrencyExchange;

use App\Exceptions\Wallet\WalletActionException;

class EuroLink extends UsdLink
{
    public const EURO = 'EUR';

    protected array $currencyExchangeRates;

    /**
     * @param string $currency
     * @param float $amount
     *
     * @return float
     *
     * @throws WalletActionException
     */
    public function exchange(string $currency, float $amount): float
    {
        if (self::EURO == $currency) {
            return $amount;
        }

        return parent::exchange($currency, $amount);
    }
}
