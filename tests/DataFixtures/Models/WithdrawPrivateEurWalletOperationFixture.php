<?php

declare(strict_types=1);

namespace Tests\DataFixtures\Models;

use App\Chains\ChainOfCurrencyExchange\EuroLink;
use App\Chains\ChainOfWithdrawRules\PrivateLink;
use App\Models\Actions\WalletOperation;
use App\Contracts\Services\Wallet\WalletWithdrawCalculateManagerInterface as WalletWithdrawAction;

class WithdrawPrivateEurWalletOperationFixture
{
    public static function get(): WalletOperation
    {
        return (new WalletOperation())
            ->setUserId(1)
            ->setDateOfAction('2020-10-20')
            ->setCurrency(EuroLink::EURO)
            ->setClientType(PrivateLink::CLIENT_TYPE)
            ->setActionType(WalletWithdrawAction::ACTION)
            ->setActionAmount(300);
    }
}
