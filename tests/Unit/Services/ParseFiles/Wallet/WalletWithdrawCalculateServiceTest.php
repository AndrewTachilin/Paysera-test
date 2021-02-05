<?php

declare(strict_types=1);

namespace Tests\Unit\Services\ParseFiles\Wallet;

use App\Services\Wallet\MathOperations;
use App\Services\Wallet\WalletWithdrawCalculateService;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Utils;
use PHPUnit\Framework\MockObject\MockObject;
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

    public function setUp(): void
    {
        $this->client = $this->createMock(Client::class);
        $body = Utils::streamFor(ApiExchangeRatesFixture::get());
        $this->response = new Response(200, ['Content-Type' => 'application/json'], $body);
        $this->walletWithdrawCalculateService = new WalletWithdrawCalculateService(new MathOperations(), $this->client);
    }

    public function testCalculateCommissionFeeForPrivateEurTypeReturnArray(): void
    {
        $walletOperation = WithdrawPrivateEurWalletOperationFixture::get();

        $walletOperationCollection = WithdrawPrivateEurWalletOperationCollectionFixture::get();

        $this->client->expects($this->once())
            ->method('send')
            ->willReturn($this->response);


        $result = $this->walletWithdrawCalculateService->calculateCommissionFee(
            $walletOperation,
            $walletOperationCollection
        );

        $this->assertEquals(0.00, $result[0]);
        $this->assertEquals($walletOperation, $result[1]->first());
    }

    public function testCalculateCommissionFeeForBusinessEurTypeReturnArray(): void
    {
        $walletOperation = WithdrawBusinessWalletOperationFixture::get();

        $walletOperationCollection = WithdrawBusinessEurWalletOperationCollectionFixture::get();

        $result = $this->walletWithdrawCalculateService->calculateCommissionFee(
            $walletOperation,
            $walletOperationCollection
        );

        $this->assertEquals(1.50, $result[0]);
        $this->assertEquals($walletOperation, $result[1]->first());
    }

    public function testUserMadeFourActionTypeCommissionWillTakenReturnArray(): void
    {
        $walletOperation = WithdrawPrivateEurHighWalletOperationFixture::get();
        $walletOperationCollection = WithdrawPrivateHighAmountActionCollection::get();

        $this->client->expects($this->once())
            ->method('send')
            ->willReturn($this->response);

        $result = $this->walletWithdrawCalculateService->calculateCommissionFee(
            $walletOperation,
            $walletOperationCollection
        );

        $this->assertEquals(30.00, $result[0]);
        $this->assertEquals($walletOperation, $result[1]->first());
    }
}
