<?php

declare(strict_types=1);

namespace Tests\DataFixtures\Models;

use App\Contracts\Strategies\EuroExchangeInterface;
use App\Models\Actions\WalletOperation;
use App\Contracts\Services\Wallet\WalletWithdrawCalculateManagerInterface as WalletWithdrawAction;
use App\Strategies\WithdrawRules\PrivateStrategy;

class WithdrawPrivateEurWalletOperationFixture
{
    public static function get(): WalletOperation
    {
        return (new WalletOperation())
            ->setUserId(1)
            ->setDateOfAction('2020-10-20')
            ->setCurrency(EuroExchangeInterface::EURO)
            ->setClientType(PrivateStrategy::CLIENT_TYPE)
            ->setActionType(WalletWithdrawAction::ACTION)
            ->setActionAmount(300);
    }
}
