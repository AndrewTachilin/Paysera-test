<?php

declare(strict_types=1);

namespace App\Chains\ChainOfCurrencyExchange;

use App\Contracts\Chains\ChainOfCurrencyExchangeInterface;
use App\Exceptions\Wallet\WalletActionException;
use App\Services\Wallet\MathOperations;

class UsdLink extends MathOperations implements ChainOfCurrencyExchangeInterface
{
    public const USD = 'USD';

    protected array $currencyExchangeRates;

    public function __construct(array $currencyExchangeRates)
    {
        $this->currencyExchangeRates = $currencyExchangeRates;
    }

    public function exchange(string $currency, float $amount): float
    {
        if (self::USD == $currency && isset($this->currencyExchangeRates[$currency])) {
            return $this->convertCurrency($amount, $this->currencyExchangeRates[$currency]);
        }

        throw new WalletActionException('This currency is not supported by system');
    }
}
