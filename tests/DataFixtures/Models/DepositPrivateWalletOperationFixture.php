<?php

declare(strict_types=1);

namespace Tests\DataFixtures\Models;

use App\Chains\ChainOfCurrencyExchange\UsdLink;
use App\Chains\ChainOfWithdrawRules\PrivateLink;
use App\Models\Actions\WalletOperation;
use App\Contracts\Services\Wallet\WalletDepositCalculateManagerInterface as WalletDepositAction;

class DepositPrivateWalletOperationFixture
{
    public static function get(): WalletOperation
    {
        return (new WalletOperation())
            ->setUserId(1)
            ->setDateOfAction('2020-10-20')
            ->setCurrency(UsdLink::USD)
            ->setClientType(PrivateLink::CLIENT_TYPE)
            ->setActionType(WalletDepositAction::ACTION)
            ->setActionAmount(300);
    }
}
