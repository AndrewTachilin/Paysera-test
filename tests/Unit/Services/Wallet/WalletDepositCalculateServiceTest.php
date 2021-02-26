<?php

declare(strict_types=1);

namespace Tests\Unit\Services\Wallet;

use App\Services\Wallet\MathOperations;
use App\Services\Wallet\WalletDepositCalculateService;
use Tests\DataFixtures\Api\ApiExchangeRatesArrayFixture;
use Tests\DataFixtures\Collections\DepositPrivateWalletOperationCollectionFixture;
use Tests\DataFixtures\Models\DepositPrivateWalletOperationFixture;
use Tests\TestCase;

class WalletDepositCalculateServiceTest extends TestCase
{
    private WalletDepositCalculateService $walletDepositCalculateService;

    private array $apiExchangeCurrency;

    public function setUp(): void
    {
        parent::setUp();

        $this->apiExchangeCurrency = ApiExchangeRatesArrayFixture::get();
        $this->walletDepositCalculateService = new WalletDepositCalculateService(new MathOperations());
    }

    public function testCalculateCommissionFeeReturnArray(): void
    {
        $walletOperation = DepositPrivateWalletOperationFixture::get();

        $walletOperationCollection = DepositPrivateWalletOperationCollectionFixture::get();

        $result = $this->walletDepositCalculateService->calculateCommissionFee(
            $walletOperation,
            $walletOperationCollection,
            $this->apiExchangeCurrency
        );

        $this->assertEquals(9, $result);
    }
}
