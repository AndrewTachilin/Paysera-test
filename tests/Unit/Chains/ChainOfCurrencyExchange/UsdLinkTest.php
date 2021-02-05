<?php

declare(strict_types=1);

namespace Tests\Unit\Chains\ChainOfCurrencyExchange;

use App\Chains\ChainOfWalletAction\DepositLink;
use App\Exceptions\Wallet\WalletActionException;
use Tests\DataFixtures\Models\WithdrawBusinessWalletOperationFixture;
use Tests\TestCase;

class UsdLinkTest extends TestCase
{
    public function testDetectClientTypeReturnString(): void
    {
        $walletFixture = WithdrawBusinessWalletOperationFixture::get();

        $result = (new DepositLink($walletFixture))->detectTypeOfAction();

        $this->assertEquals($walletFixture->getActionType(), $result);
    }

    public function testDetectClientTypeReturnException(): void
    {
        $this->expectException(WalletActionException::class);
        $walletFixture = WithdrawBusinessWalletOperationFixture::get()->setActionType('q');

        (new DepositLink($walletFixture))->detectTypeOfAction();
    }
}
