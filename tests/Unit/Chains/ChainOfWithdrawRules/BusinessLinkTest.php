<?php

declare(strict_types=1);

namespace Tests\Unit\Chains\ChainOfWithdrawRules;

use App\Chains\ChainOfWithdrawRules\BusinessLink;
use App\Services\Wallet\MathOperations;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Utils;
use PHPUnit\Framework\MockObject\MockObject;
use Tests\DataFixtures\Api\ApiExchangeRatesFixture;
use Tests\DataFixtures\Collections\WithdrawBusinessEurWalletOperationCollectionFixture;
use Tests\DataFixtures\Models\WithdrawBusinessWalletOperationFixture;
use Tests\TestCase;

class BusinessLinkTest extends TestCase
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

    public function testCalculateCommissionWhenReturnWithCommission(): void
    {
        $walletFixture = WithdrawBusinessWalletOperationFixture::get();
        $walletCollection = WithdrawBusinessEurWalletOperationCollectionFixture::get();

        $result = (new BusinessLink(
            $walletFixture,
            $this->mathOperations,
            $this->client
        ))->detectClientType($walletCollection);

        $this->assertEquals(1.50, $result[0]);
    }
}
