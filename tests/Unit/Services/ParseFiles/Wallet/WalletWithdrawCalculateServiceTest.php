<?php

declare(strict_types=1);

namespace Tests\Unit\Services\ParseFiles\Wallet;

use App\Chains\ChainOfCurrencyExchange\EuroStrategy;
use App\Chains\ChainOfCurrencyExchange\JpyStrategy;
use App\Chains\ChainOfCurrencyExchange\UsdStrategy;
use App\Services\Wallet\MathOperations;
use App\Services\Wallet\WalletWithdrawCalculateService;
use App\Strategies\WithdrawRules\BusinessStrategy;
use App\Strategies\WithdrawRules\PrivateStrategy;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Utils;
use Illuminate\Support\Facades\Config;
use PHPUnit\Framework\MockObject\MockObject;
use Tests\DataFixtures\Api\ApiExchangeRatesFixture;
use Tests\DataFixtures\Collections\WithdrawBusinessEurWalletOperationCollectionFixture;
use Tests\DataFixtures\Collections\WithdrawPrivateEurWalletOperationCollectionFixture;
use Tests\DataFixtures\Collections\WithdrawPrivateHighAmountActionCollection;
use Tests\DataFixtures\Models\WithdrawBusinessWalletOperationFixture;
use Tests\DataFixtures\Models\WithdrawPrivateEurHighWalletOperationFixture;
use Tests\DataFixtures\Models\WithdrawPrivateEurWalletOperationFixture;
use Tests\TestCase;
use Illuminate\Config\Repository;

class WalletWithdrawCalculateServiceTest extends TestCase
{
    private WalletWithdrawCalculateService $walletWithdrawCalculateService;

    /** @var Response|MockObject */
    protected $response;

    /** @var Client|MockObject */
    private $client;

    private Repository $repository;

    public function setUp(): void
    {
        parent::setUp();

//        $this->app->get('config')->get('app');

        $mathOperations = new MathOperations();

        $currencyExchange = [
            new UsdStrategy($mathOperations),
            new JpyStrategy($mathOperations),
            new EuroStrategy($mathOperations),
        ];


        $privateStrategy = new PrivateStrategy($mathOperations, new Client(), $currencyExchange);
        $businessStrategy = new BusinessStrategy($mathOperations);

        $this->client = $this->createMock(Client::class);
        $body = Utils::streamFor(ApiExchangeRatesFixture::get());
        $this->response = new Response(200, ['Content-Type' => 'application/json'], $body);
        $this->walletWithdrawCalculateService = new WalletWithdrawCalculateService([
            $privateStrategy, $businessStrategy
        ]);
    }

    public function testCalculateCommissionFeeForPrivateEurTypeReturnArray(): void
    {
        $walletOperation = WithdrawPrivateEurWalletOperationFixture::get();
        $walletOperationCollection = WithdrawPrivateEurWalletOperationCollectionFixture::get();

        $result = $this->walletWithdrawCalculateService->calculateCommissionFee(
            $walletOperation,
            $walletOperationCollection
        );

        $this->assertEquals(0.00, $result);
    }

    public function testCalculateCommissionFeeForBusinessEurTypeReturnArray(): void
    {
        $walletOperation = WithdrawBusinessWalletOperationFixture::get();
        $walletOperationCollection = WithdrawBusinessEurWalletOperationCollectionFixture::get();

        $result = $this->walletWithdrawCalculateService->calculateCommissionFee(
            $walletOperation,
            $walletOperationCollection
        );

        $this->assertEquals(1, $result[0]);
    }

    public function testUserMadeFourActionTypeCommissionWillTakenReturnArray(): void
    {
        $walletOperation = WithdrawPrivateEurHighWalletOperationFixture::get();
        $walletOperationCollection = WithdrawPrivateHighAmountActionCollection::get();

        $result = $this->walletWithdrawCalculateService->calculateCommissionFee(
            $walletOperation,
            $walletOperationCollection
        );

        $this->assertEquals(30.00, $result);
    }
}
