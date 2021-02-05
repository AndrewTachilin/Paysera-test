<?php

declare(strict_types=1);

namespace Tests\DataFixtures\Models;

use App\Chains\ChainOfCurrencyExchange\EuroLink;
use App\Chains\ChainOfWithdrawRules\PrivateLink;
use App\Contracts\Services\Wallet\WalletWithdrawCalculateManagerInterface as WalletWithdrawAction;

class WalletOperationArrayFixture
{
    public static function get(): array
    {
        return [
            '2020-10-20',
            1,
            PrivateLink::CLIENT_TYPE,
            WalletWithdrawAction::ACTION,
            10000,
            EuroLink::EURO,

        ];
    }
}
