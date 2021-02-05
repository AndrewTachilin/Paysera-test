<?php

declare(strict_types=1);

namespace Tests\Unit\Chains\ChainOfCurrencyExchange;

use App\Chains\ChainOfCurrencyExchange\JpyLink;
use Tests\DataFixtures\Api\ApiExchangeRatesArrayFixture;
use Tests\DataFixtures\Models\WithdrawBusinessWalletOperationFixture;
use Tests\TestCase;

class JpyLinkTest extends TestCase
{
    public function testExchangeCurrencyJpyReturnFloat(): void
    {
        $walletFixture = WithdrawBusinessWalletOperationFixture::get();

        $result = (new JpyLink(ApiExchangeRatesArrayFixture::get()))
            ->exchange(JpyLink::JPY, $walletFixture->getActionAmount());

        $this->assertEquals(37872.00, $result);
    }
}
