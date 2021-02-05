<?php

declare(strict_types=1);

namespace App\Chains\ChainOfCurrencyExchange;

use App\Exceptions\Wallet\WalletActionException;

class JpyLink extends EuroLink
{
    public const JPY = 'JPY';

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
        if (self::JPY == $currency && isset($this->currencyExchangeRates[$currency])) {
            return $this->convertCurrency($amount, $this->currencyExchangeRates[$currency]);
        }

        return parent::exchange($currency, $amount);
    }
}
