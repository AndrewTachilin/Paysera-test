<?php

declare(strict_types=1);

namespace Tests\DataFixtures\Models;

use App\Contracts\Strategies\JpyExchangeInterface;
use App\Models\Actions\WalletOperation;
use App\Contracts\Services\Wallet\WalletDepositCalculateManagerInterface as WalletDepositAction;
use App\Strategies\WithdrawRules\PrivateStrategy;

class DepositPrivateJpyWalletOperationFixture
{
    public static function get(): WalletOperation
    {
        return (new WalletOperation())
            ->setUserId(1)
            ->setDateOfAction('2020-10-20')
            ->setCurrency(JpyExchangeInterface::JPY)
            ->setClientType(PrivateStrategy::CLIENT_TYPE)
            ->setActionType(WalletDepositAction::ACTION)
            ->setActionAmount(300);
    }
}