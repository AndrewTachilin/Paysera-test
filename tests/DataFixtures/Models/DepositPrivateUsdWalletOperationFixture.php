<?php

declare(strict_types=1);

namespace Tests\DataFixtures\Models;

use App\Chains\ChainOfCurrencyExchange\UsdStrategy;
use App\Models\Actions\WalletOperation;
use App\Contracts\Services\Wallet\WalletDepositCalculateManagerInterface as WalletDepositAction;
use App\Strategies\WithdrawRules\PrivateStrategy;

class DepositPrivateUsdWalletOperationFixture
{
    public static function get(): WalletOperation
    {
        return (new WalletOperation())
            ->setUserId(1)
            ->setDateOfAction('2020-10-20')
            ->setCurrency(UsdStrategy::USD)
            ->setClientType(PrivateStrategy::CLIENT_TYPE)
            ->setActionType(WalletDepositAction::ACTION)
            ->setActionAmount(300);
    }
}
