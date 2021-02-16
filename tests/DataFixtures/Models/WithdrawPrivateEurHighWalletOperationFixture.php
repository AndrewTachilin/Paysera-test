<?php

declare(strict_types=1);

namespace Tests\DataFixtures\Models;

use App\Contracts\Strategies\EuroExchangeInterface;
use App\Contracts\Strategies\PrivateStrategyInterface;
use App\Models\Actions\WalletOperation;
use App\Contracts\Services\Wallet\WalletWithdrawCalculateManagerInterface as WalletWithdrawAction;

class WithdrawPrivateEurHighWalletOperationFixture
{
    public static function get(): WalletOperation
    {
        return (new WalletOperation())
            ->setUserId(1)
            ->setDateOfAction('2020-10-20')
            ->setCurrency(EuroExchangeInterface::EURO)
            ->setClientType(PrivateStrategyInterface::CLIENT_TYPE)
            ->setActionType(WalletWithdrawAction::ACTION)
            ->setActionAmount(10000);
    }
}
