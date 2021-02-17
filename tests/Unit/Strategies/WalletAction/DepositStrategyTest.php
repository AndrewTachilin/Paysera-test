<?php

declare(strict_types=1);

namespace Tests\Unit\Strategies\WalletAction;

use App\Exceptions\Wallet\WalletActionException;
use App\Strategies\WalletAction\DepositStrategy;
use Tests\DataFixtures\Models\DepositPrivateWalletOperationFixture;
use Tests\DataFixtures\Models\WithdrawPrivateEurHighWalletOperationFixture;
use Tests\TestCase;

class DepositStrategyTest extends TestCase
{
    private DepositStrategy $depositStrategy;

    public function testDetectTypeOfActionReturnAction(): void
    {
        $model = DepositPrivateWalletOperationFixture::get();
        $this->depositStrategy = new DepositStrategy($model);
        $result = $this->depositStrategy->detectTypeOfAction();

        $this->assertEquals(config('app.wallet_actions.wallet_action_deposit'), $result);
    }

    public function testDetectTypeOfActionReturnException(): void
    {
        $this->expectException(WalletActionException::class);
        $model = WithdrawPrivateEurHighWalletOperationFixture::get();

        $this->depositStrategy = new DepositStrategy($model);
        $this->depositStrategy->detectTypeOfAction();
    }
}
