<?php

declare(strict_types=1);

namespace Tests\Unit\Services\CurrencyExchange;

use App\Contracts\Strategies\EuroExchangeInterface;
use App\Contracts\Strategies\JpyExchangeInterface;
use App\Contracts\Strategies\UsdExchangeInterface;
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
        $fromAmount = 1000;
        $result = $this->currencyExchange->exchange(EuroExchangeInterface::EURO, $fromAmount, $this->currencyExchangeRate);

        $this->assertEquals($fromAmount, $result);
    }

    public function testCalculateCommissionForUsdReturnAmount(): void
    {
        $fromAmount = 1000;
        $result = $this->currencyExchange->exchange(UsdExchangeInterface::USD, $fromAmount, $this->currencyExchangeRate);

        $this->assertEquals(1199.6, $result);
    }

    public function testCalculateCommissionForJpyReturnAmount(): void
    {
        $fromAmount = 1000;
        $result = $this->currencyExchange->exchange(JpyExchangeInterface::JPY, $fromAmount, $this->currencyExchangeRate);

        $this->assertEquals(126240, $result);
    }
}
