<?php

declare(strict_types=1);

namespace Tests\Unit\Services\Wallet;

use App\DataTransformer\WalletOperationDataTransformer;
use App\Services\CurrencyExchange\CurrencyExchangeService;
use App\Services\Wallet\MathOperations;
use App\Services\Wallet\WalletWithdrawCalculateService;
use App\Strategies\WithdrawRules\BusinessStrategy;
use App\Strategies\WithdrawRules\PrivateStrategy;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Utils;
use PHPUnit\Framework\MockObject\MockObject;
use Tests\DataFixtures\Api\ApiExchangeRatesArrayFixture;
use Tests\DataFixtures\Api\ApiExchangeRatesFixture;
use Tests\DataFixtures\Collections\WithdrawBusinessEurWalletOperationCollectionFixture;
use Tests\DataFixtures\Collections\WithdrawPrivateEurWalletOperationCollectionFixture;
use Tests\DataFixtures\Collections\WithdrawPrivateHighAmountActionCollection;
use Tests\DataFixtures\Models\WithdrawBusinessWalletOperationFixture;
use Tests\DataFixtures\Models\WithdrawPrivateEurHighWalletOperationFixture;
use Tests\DataFixtures\Models\WithdrawPrivateEurWalletOperationFixture;
use Tests\TestCase;

class WalletWithdrawCalculateServiceTest extends TestCase
{
    private WalletWithdrawCalculateService $walletWithdrawCalculateService;

    /** @var Response|MockObject */
    protected $response;

    /** @var Client|MockObject */
    private $client;

    private array $apiExchangeCurrency;

    public function setUp(): void
    {
        parent::setUp();

        $this->apiExchangeCurrency = ApiExchangeRatesArrayFixture::get();
        $mathOperations = new MathOperations();
        $currencyExchange = new CurrencyExchangeService($mathOperations);
        $dataTransformer = new WalletOperationDataTransformer($mathOperations);

        $privateStrategy = new PrivateStrategy($mathOperations, $currencyExchange, $dataTransformer);
        $businessStrategy = new BusinessStrategy($mathOperations, $dataTransformer);

        $this->client = $this->createMock(Client::class);
        $body = Utils::streamFor(ApiExchangeRatesFixture::get());
        $this->response = new Response(200, ['Content-Type' => 'application/json'], $body);
        $this->walletWithdrawCalculateService = new WalletWithdrawCalculateService([
            $privateStrategy, $businessStrategy
        ]);
    }

    public function testCalculateCommissionFeeForPrivateEurTypeReturnInt(): void
    {
        $walletOperation = WithdrawPrivateEurWalletOperationFixture::get();
        $walletOperationCollection = WithdrawPrivateEurWalletOperationCollectionFixture::get();

        $result = $this->walletWithdrawCalculateService->calculateCommissionFee(
            $walletOperation,
            $walletOperationCollection,
            $this->apiExchangeCurrency
        );

        $this->assertEquals(0.00, $result);
    }

    public function testCalculateCommissionFeeForBusinessEurTypeReturnInt(): void
    {
        $walletOperation = WithdrawBusinessWalletOperationFixture::get();
        $walletOperationCollection = WithdrawBusinessEurWalletOperationCollectionFixture::get();

        $result = $this->walletWithdrawCalculateService->calculateCommissionFee(
            $walletOperation,
            $walletOperationCollection,
            $this->apiExchangeCurrency
        );

        $this->assertEquals(150, $result);
    }

    public function testUserMadeFourActionTypeCommissionWillTakenReturnInt(): void
    {
        $walletOperation = WithdrawPrivateEurHighWalletOperationFixture::get();
        $walletOperationCollection = WithdrawPrivateHighAmountActionCollection::get();

        $result = $this->walletWithdrawCalculateService->calculateCommissionFee(
            $walletOperation,
            $walletOperationCollection,
            $this->apiExchangeCurrency
        );

        $this->assertEquals(3000, $result);
    }
}
