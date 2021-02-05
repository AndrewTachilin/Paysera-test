<?php

declare(strict_types=1);

namespace Tests\Unit\Services\ParseFiles\Wallet;

use App\Services\Wallet\WalletDepositCalculateService;
use Tests\DataFixtures\Collections\DepositPrivateWalletOperationCollectionFixture;
use Tests\DataFixtures\Models\DepositPrivateWalletOperationFixture;
use Tests\TestCase;

class WalletDepositCalculateServiceTest extends TestCase
{
    private WalletDepositCalculateService $walletDepositCalculateService;

    public function setUp(): void
    {
        $this->walletDepositCalculateService = new WalletDepositCalculateService();
    }

    public function testCalculateCommissionFeeReturnArray(): void
    {
        $walletOperation = DepositPrivateWalletOperationFixture::get();

        $walletOperationCollection = DepositPrivateWalletOperationCollectionFixture::get();

        $result = $this->walletDepositCalculateService->calculateCommissionFee(
            $walletOperation,
            $walletOperationCollection
        );

        $this->assertEquals(0.09, $result[0]);
        $this->assertEquals($walletOperation, $result[1]->first());
    }
}
