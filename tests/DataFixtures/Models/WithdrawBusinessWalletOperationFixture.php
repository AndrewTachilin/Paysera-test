<?php

declare(strict_types=1);

namespace Tests\DataFixtures\Models;

use App\Chains\ChainOfCurrencyExchange\EuroLink;
use App\Chains\ChainOfWithdrawRules\BusinessLink;
use App\Models\Actions\WalletOperation;
use App\Contracts\Services\Wallet\WalletDepositCalculateManagerInterface as WalletDepositAction;

class WithdrawBusinessWalletOperationFixture
{
    public static function get(): WalletOperation
    {
        return (new WalletOperation())
            ->setUserId(1)
            ->setDateOfAction('2020-10-20')
            ->setCurrency(EuroLink::EURO)
            ->setClientType(BusinessLink::CLIENT_TYPE)
            ->setActionType(WalletDepositAction::ACTION)
            ->setActionAmount(300);
    }
}
