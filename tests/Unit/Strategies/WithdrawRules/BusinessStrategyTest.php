<?php

declare(strict_types=1);

namespace Tests\Unit\Strategies\WithdrawRules;

use App\DataTransformer\WalletOperationDataTransformer;
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
        $mathOperation = new MathOperations();
        $this->businessStrategy = new BusinessStrategy($mathOperation, new WalletOperationDataTransformer($mathOperation));
    }

    public function testCommissionFreeOnFirstActionBusinessReturnCommission(): void
    {
        $walletModel = WithdrawBusinessWalletOperationFixture::get();
        $walletCollection = WithdrawBusinessEurWalletOperationCollectionFixture::get();

        $result = $this->businessStrategy->detectClientType($walletCollection, $walletModel);

        $this->assertEquals(150, $result);
    }
}
