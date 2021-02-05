<?php

declare(strict_types=1);

namespace Tests\Unit\Chains\ChainOfCurrencyExchange;

use App\Chains\ChainOfCurrencyExchange\EuroLink;
use Tests\DataFixtures\Api\ApiExchangeRatesArrayFixture;
use Tests\DataFixtures\Models\WithdrawBusinessWalletOperationFixture;
use Tests\TestCase;

class EuroLinkTest extends TestCase
{
    public function testExchangeCurrencyEurReturnFloat(): void
    {
        $walletFixture = WithdrawBusinessWalletOperationFixture::get();

        $result = (new EuroLink(ApiExchangeRatesArrayFixture::get()))
            ->exchange(EuroLink::EURO, $walletFixture->getActionAmount());

        $this->assertEquals(300, $result);
    }
}
