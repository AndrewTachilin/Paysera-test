<?php

declare(strict_types=1);

namespace Tests\Unit\Chains\ChainOfWithdrawActions;

use App\Chains\ChainOfWalletAction\WithdrawLink;
use App\Exceptions\Wallet\WalletActionException;
use Tests\DataFixtures\Models\WithdrawBusinessWalletOperationFixture;
use Tests\TestCase;

class WithdrawLinkTest extends TestCase
{
    public function testDetectClientTypeReturnString(): void
    {
        $walletFixture = WithdrawBusinessWalletOperationFixture::get();

        $result = (new WithdrawLink($walletFixture))->detectTypeOfAction();

        $this->assertEquals($walletFixture->getActionType(), $result);
    }

    public function testDetectClientTypeReturnException(): void
    {
        $this->expectException(WalletActionException::class);
        $walletFixture = WithdrawBusinessWalletOperationFixture::get()->setActionType('q');

        (new WithdrawLink($walletFixture))->detectTypeOfAction();
    }
}
