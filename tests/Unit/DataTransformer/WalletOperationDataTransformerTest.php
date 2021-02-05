<?php

declare(strict_types=1);

namespace Tests\Unit\DataTransformer;

use App\DataTransformer\WalletOperationDataTransformer;
use App\Exceptions\ValidationException\ValidationException;
use Tests\DataFixtures\Models\DepositPrivateWalletOperationFixture;
use Tests\DataFixtures\Models\WalletOperationArrayFixture;
use Tests\DataFixtures\Models\WithdrawPrivateEurHighWalletOperationFixture;
use Tests\TestCase;

class WalletOperationDataTransformerTest extends TestCase
{
    private WalletOperationDataTransformer $dataTransformer;

    public function setUp(): void
    {
        $this->dataTransformer = new WalletOperationDataTransformer();
    }

    public function testTransformFromArrayToWalletReturnModel(): void
    {
        $walletArray = WalletOperationArrayFixture::get();
        $walletModel = WithdrawPrivateEurHighWalletOperationFixture::get();

        $result = $this->dataTransformer->transformFromArray($walletArray);

        $this->assertEquals($walletModel->getUserId(), $result->getUserId());
        $this->assertEquals($walletModel->getDateOfAction(), $result->getDateOfAction());
        $this->assertEquals($walletModel->getCurrency(), $result->getCurrency());
        $this->assertEquals($walletModel->getClientType(), $result->getClientType());
        $this->assertEquals($walletModel->getActionType(), $result->getActionType());
        $this->assertEquals($walletModel->getActionAmount(), $result->getActionAmount());
    }

    public function testTransformUpdateModelToWalletReturnModel(): void
    {
        $wallet = DepositPrivateWalletOperationFixture::get();
        $walletHighModel = WithdrawPrivateEurHighWalletOperationFixture::get();

        $result = $this->dataTransformer->resetAmountWalletOperation($wallet, $walletHighModel->getActionAmount());

        $this->assertEquals($wallet->getUserId(), $result->getUserId());
        $this->assertEquals($wallet->getDateOfAction(), $result->getDateOfAction());
        $this->assertEquals($wallet->getCurrency(), $result->getCurrency());
        $this->assertEquals($wallet->getClientType(), $result->getClientType());
        $this->assertEquals($wallet->getActionType(), $result->getActionType());
        $this->assertEquals($walletHighModel->getActionAmount(), $result->getActionAmount());
    }

    public function testTransformUpdateModelToWalletReturnException(): void
    {
        $this->expectException(ValidationException::class);

        $this->dataTransformer->transformFromArray([]);
    }
}
