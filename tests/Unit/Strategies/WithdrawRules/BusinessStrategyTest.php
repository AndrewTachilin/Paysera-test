<?php

declare(strict_types=1);

namespace Tests\Unit\DataTransformer;

use App\Services\Wallet\MathOperations;
use App\Strategies\WithdrawRules\BusinessStrategy;
use Tests\DataFixtures\Collections\WithdrawBusinessEurWalletOperationCollectionFixture;
use Tests\DataFixtures\Models\WithdrawBusinessWalletOperationFixture;
use Tests\TestCase;

class BusinessStrategyTest extends TestCase
{
    private BusinessStrategy $businessStrategy;

    public function setUp(): void
    {
        parent::setUp();
        $this->businessStrategy = new BusinessStrategy(new MathOperations());
    }

    public function testCommissionFreeOnFirstActionBusinessReturnCommission(): void
    {
        $walletModel = WithdrawBusinessWalletOperationFixture::get();
        $walletCollection = WithdrawBusinessEurWalletOperationCollectionFixture::get();

        $result = $this->businessStrategy->detectClientType($walletCollection, $walletModel);

        $this->assertIsFloat(1.50, $result);
    }
}
