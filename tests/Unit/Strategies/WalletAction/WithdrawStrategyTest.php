<?php

declare(strict_types=1);

namespace Tests\Unit\Strategies\WalletAction;

use App\Contracts\Strategies\WithdrawStrategyInterface;
use App\Exceptions\Wallet\WalletActionException;
use App\Strategies\WalletAction\WithdrawStrategy;
use Tests\DataFixtures\Models\DepositPrivateWalletOperationFixture;
use Tests\DataFixtures\Models\WithdrawPrivateEurHighWalletOperationFixture;
use Tests\TestCase;

class WithdrawStrategyTest extends TestCase
{
    public function testDetectTypeOfActionReturnAction(): void
    {
        $model = WithdrawPrivateEurHighWalletOperationFixture::get();
        $withdrawStrategy = new WithdrawStrategy($model);

        $result = $withdrawStrategy->detectTypeOfAction();

        $this->assertEquals(WithdrawStrategyInterface::TYPE, $result);
    }

    public function testDetectTypeOfActionReturnException(): void
    {
        $this->expectException(WalletActionException::class);
        $model = DepositPrivateWalletOperationFixture::get();

        $withdrawStrategy = new WithdrawStrategy($model);
        $withdrawStrategy->detectTypeOfAction();
    }
}
