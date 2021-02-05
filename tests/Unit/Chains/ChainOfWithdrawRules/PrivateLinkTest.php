<?php

declare(strict_types=1);

namespace Tests\Unit\Chains\ChainOfWithdrawRules;

use App\Chains\ChainOfWithdrawRules\PrivateLink;
use App\Models\Actions\WalletOperation;
use App\Services\Wallet\MathOperations;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Utils;
use PHPUnit\Framework\MockObject\MockObject;
use Tests\DataFixtures\Api\ApiExchangeRatesFixture;
use Tests\DataFixtures\Collections\WithdrawPrivateEurWalletOperationCollectionFixture;
use Tests\DataFixtures\Collections\WithdrawPrivateHighAmountActionCollection;
use Tests\DataFixtures\Collections\WithdrawPrivateUserMadeFourActionCollection;
use Tests\DataFixtures\Models\WithdrawPrivateEurHighWalletOperationFixture;
use Tests\DataFixtures\Models\WithdrawPrivateEurWalletOperationFixture;
use Tests\TestCase;

class PrivateLinkTest extends TestCase
{
    private MathOperations $mathOperations;

    /** @var Client|MockObject */
    private $client;

    public function setUp(): void
    {
        $this->mathOperations = new MathOperations();
        $this->client = $this->createMock(Client::class);
        $body = Utils::streamFor(ApiExchangeRatesFixture::get());
        $this->response = new Response(200, ['Content-Type' => 'application/json'], $body);
    }

    public function testCalculateCommissionWhenAmountLessThousandReturnWithoutCommission(): void
    {
        $walletFixture = WithdrawPrivateEurWalletOperationFixture::get();
        $walletCollection = WithdrawPrivateEurWalletOperationCollectionFixture::get();

        $this->client->expects($this->once())
        ->method('send')
        ->willReturn($this->response);


        $result = (new PrivateLink(
            $walletFixture,
            $this->mathOperations,
            $this->client
        ))->detectClientType($walletCollection);

        $sum = 0;
        $walletCollection->sum(function (WalletOperation $item) use (&$sum) {
            $sum += $item->getActionAmount();
        });

        $this->assertEquals(0.00, $result[0]);
        $this->assertLessThan(1000, $sum);
    }

    public function testCalculateCommissionWhenAmountMoreThousandReturnWithCommission(): void
    {
        $walletFixture = WithdrawPrivateEurHighWalletOperationFixture::get();
        $walletCollection = WithdrawPrivateHighAmountActionCollection::get();

        $this->client->expects($this->once())
            ->method('send')
            ->willReturn($this->response);


        $result = (new PrivateLink(
            $walletFixture,
            $this->mathOperations,
            $this->client
        ))->detectClientType($walletCollection);

        $sum = 0;
        $walletCollection->sum(function (WalletOperation $item) use (&$sum) {
            $sum += $item->getActionAmount();
        });

        $this->assertEquals(30.00, $result[0]);
        $this->assertGreaterThan(1000, $sum);
    }


    public function testCalculateCommissionWhenAmountMoreThenFourReturnWithCommission(): void
    {
        $walletCollection = WithdrawPrivateUserMadeFourActionCollection::get();

        $this->client->expects($this->once())
            ->method('send')
            ->willReturn($this->response);


        $result = (new PrivateLink(
            $walletCollection->first(),
            $this->mathOperations,
            $this->client
        ))->detectClientType($walletCollection);

        $sum = 0;
        $walletCollection->sum(function (WalletOperation $item) use (&$sum) {
            $sum += $item->getActionAmount();
        });

        $this->assertEquals(0.90, $result[0]);
        $this->assertGreaterThan(1000, $sum);
    }
}
