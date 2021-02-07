<?php

declare(strict_types=1);

namespace Tests\Unit\DataTransformer;

use App\Chains\ChainOfCurrencyExchange\EuroStrategy;
use App\Services\Wallet\MathOperations;
use Tests\DataFixtures\Api\ApiExchangeRatesArrayFixture;
use Tests\DataFixtures\Models\WithdrawBusinessWalletOperationFixture;
use Tests\TestCase;

class EurStrategyTest extends TestCase
{
    private EuroStrategy $eurStrategy;

    public function setUp(): void
    {
        parent::setUp();
        $this->eurStrategy = new EuroStrategy(new MathOperations());
    }

    public function testCommissionFreeOnFirstActionBusinessReturnCommission(): void
    {
        $walletModel = WithdrawBusinessWalletOperationFixture::get();

        $result = $this->eurStrategy->exchange(
            $walletModel->getCurrency(),
            $walletModel->getActionAmount(),
            ApiExchangeRatesArrayFixture::get()
        );

        $this->assertEquals($walletModel->getActionAmount(), $result);
    }
}
