<?php

declare(strict_types=1);

namespace Tests\Unit\Services\Wallet;

use App\Services\Wallet\MathOperations;
use App\Services\Wallet\WalletDepositCalculateService;
use Tests\DataFixtures\Collections\DepositPrivateWalletOperationCollectionFixture;
use Tests\DataFixtures\Models\DepositPrivateWalletOperationFixture;
use Tests\TestCase;

class WalletDepositCalculateServiceTest extends TestCase
{
    private WalletDepositCalculateService $walletDepositCalculateService;

    public function setUp(): void
    {
        parent::setUp();

        $this->walletDepositCalculateService = new WalletDepositCalculateService(new MathOperations());
    }

    public function testCalculateCommissionFeeReturnArray(): void
    {
        $walletOperation = DepositPrivateWalletOperationFixture::get();

        $walletOperationCollection = DepositPrivateWalletOperationCollectionFixture::get();

        $result = $this->walletDepositCalculateService->calculateCommissionFee(
            $walletOperation,
            $walletOperationCollection
        );

        $this->assertEquals('0.00', $result);
    }
}
