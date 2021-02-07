<?php

declare(strict_types=1);

namespace Tests\Unit\DataTransformer;

use App\Chains\ChainOfCurrencyExchange\UsdStrategy;
use App\Services\Wallet\MathOperations;
use Tests\DataFixtures\Api\ApiExchangeRatesArrayFixture;
use Tests\DataFixtures\Models\DepositPrivateJpyWalletOperationFixture;
use Tests\TestCase;

class UsdStrategyTest extends TestCase
{
    private UsdStrategy $usdStrategy;

    public function setUp(): void
    {
        parent::setUp();

        $this->usdStrategy = new UsdStrategy(new MathOperations());
    }

    public function testCommissionFreeOnFirstActionBusinessReturnCommission(): void
    {
        $walletModel = DepositPrivateJpyWalletOperationFixture::get();

        $result = $this->usdStrategy->exchange(
            $walletModel->getCurrency(),
            $walletModel->getActionAmount(),
            ApiExchangeRatesArrayFixture::get()
        );

        $this->assertEquals(37872.0, $result);
    }
}
