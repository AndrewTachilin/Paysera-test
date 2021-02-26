<?php

declare(strict_types=1);

namespace Tests\Unit\Services\CurrencyExchange;

use App\Services\CurrencyExchange\CurrencyExchangeService;
use App\Services\Wallet\MathOperations;
use Tests\DataFixtures\Api\ApiExchangeRatesArrayFixture;
use Tests\TestCase;

class CurrencyExchangeTest extends TestCase
{
    private CurrencyExchangeService $currencyExchange;

    private array $currencyExchangeRate;

    public function setUp(): void
    {
        parent::setUp();

        $mathOperations = new MathOperations();
        $this->currencyExchange = new CurrencyExchangeService($mathOperations);
        $this->currencyExchangeRate = ApiExchangeRatesArrayFixture::get();
    }

    public function testCalculateCommissionForEuroReturnAmount(): void
    {
        $fromAmount = '1000';
        $result = $this->currencyExchange->exchange(
            config('app.currencies.default_currency'),
            $fromAmount,
            $this->currencyExchangeRate
        );

        $this->assertEquals($fromAmount, $result);
    }

    public function testCalculateCommissionForUsdReturnAmount(): void
    {
        $fromAmount = '1000';
        $result = $this->currencyExchange->exchange(config('app.currencies.usd_currency'), $fromAmount, $this->currencyExchangeRate);

        $this->assertEquals(1199, $result);
    }

    public function testCalculateCommissionForJpyReturnAmount(): void
    {
        $fromAmount = '1000';
        $result = $this->currencyExchange->exchange(config('app.currencies.jpy_currency'), $fromAmount, $this->currencyExchangeRate);

        $this->assertEquals(126240, $result);
    }
}
