<?php

declare(strict_types=1);

namespace Tests\Unit\Strategies\WithdrawRules;

use App\DataTransformer\WalletOperationDataTransformer;
use App\Services\CurrencyExchange\CurrencyExchangeService;
use App\Services\Wallet\MathOperations;
use App\Strategies\WithdrawRules\PrivateStrategy;
use GuzzleHttp\Client;
use Tests\DataFixtures\Collections\WithdrawPrivateEurWalletOperationCollectionFixture;
use Tests\DataFixtures\Collections\WithdrawPrivateHighAmountActionCollection;
use Tests\DataFixtures\Collections\WithdrawPrivateUserMadeFourActionCollection;
use Tests\DataFixtures\Models\WithdrawPrivateEurHighWalletOperationFixture;
use Tests\DataFixtures\Models\WithdrawPrivateEurWalletOperationFixture;
use Tests\TestCase;

class PrivateStrategyTest extends TestCase
{
    private PrivateStrategy $privateStrategy;

    public function setUp(): void
    {
        parent::setUp();

        $mathOperations = new MathOperations();

        $currencyExchange = new CurrencyExchangeService($mathOperations);
        $this->privateStrategy = new PrivateStrategy(
            $mathOperations,
            new Client(),
            $currencyExchange,
            new WalletOperationDataTransformer($mathOperations)
        );
    }

    public function testCommissionFreeOnFirstActionOnSmallAmountReturnZero(): void
    {
        $walletModel = WithdrawPrivateEurWalletOperationFixture::get();
        $walletCollection = WithdrawPrivateEurWalletOperationCollectionFixture::get();

        $result = $this->privateStrategy->detectClientType($walletCollection, $walletModel);

        $this->assertEquals(0.00, $result);
    }

    public function testCommissionFreeOnFourthStepTakeCommissionReturnAmountCommission(): void
    {
        $walletModel = WithdrawPrivateEurWalletOperationFixture::get();
        $walletCollection = WithdrawPrivateUserMadeFourActionCollection::get();

        $result = $this->privateStrategy->detectClientType($walletCollection, $walletModel);

        $this->assertEquals(0.90, $result);
    }

    public function testCommissionOnBigAmountResultAmountCommission(): void
    {
        $walletModel = WithdrawPrivateEurHighWalletOperationFixture::get();
        $walletCollection = WithdrawPrivateHighAmountActionCollection::get();

        $result = $this->privateStrategy->detectClientType($walletCollection, $walletModel);

        $this->assertEquals(30.00, $result);
    }
}
