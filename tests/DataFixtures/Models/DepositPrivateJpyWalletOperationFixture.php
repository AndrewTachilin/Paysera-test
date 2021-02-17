<?php

declare(strict_types=1);

namespace Tests\DataFixtures\Models;

use App\Models\Actions\WalletOperation;
use App\Strategies\WithdrawRules\PrivateStrategy;

class DepositPrivateJpyWalletOperationFixture
{
    public static function get(): WalletOperation
    {
        return (new WalletOperation())
            ->setUserId(1)
            ->setDateOfAction('2020-10-20')
            ->setCurrency(config('app.jpy_currency'))
            ->setClientType(PrivateStrategy::CLIENT_TYPE)
            ->setActionType(config('app.wallet_action_deposit'))
            ->setActionAmount(30000);
    }
}
