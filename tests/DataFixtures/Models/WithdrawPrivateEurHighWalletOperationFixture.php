<?php

declare(strict_types=1);

namespace Tests\DataFixtures\Models;

use App\Contracts\Strategies\PrivateStrategyInterface;
use App\Models\Actions\WalletOperation;

class WithdrawPrivateEurHighWalletOperationFixture
{
    public static function get(): WalletOperation
    {
        return (new WalletOperation())
            ->setUserId(1)
            ->setDateOfAction('2020-10-20')
            ->setCurrency(config('app.default_currency'))
            ->setClientType(PrivateStrategyInterface::CLIENT_TYPE)
            ->setActionType(config('app.wallet_action_withdraw'))
            ->setActionAmount(1000000);
    }
}
