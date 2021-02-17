<?php

declare(strict_types=1);

namespace Tests\DataFixtures\Models;

use App\Models\Actions\WalletOperation;

class WithdrawBusinessWalletOperationFixture
{
    public static function get(): WalletOperation
    {
        return (new WalletOperation())
            ->setUserId(1)
            ->setDateOfAction('2020-10-20')
            ->setCurrency(config('app.default_currency'))
            ->setClientType(config('app.wallet_action_type_business'))
            ->setActionType(config('app.wallet_action_deposit'))
            ->setActionAmount(30000);
    }
}
