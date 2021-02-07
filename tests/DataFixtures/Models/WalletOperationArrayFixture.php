<?php

declare(strict_types=1);

namespace Tests\DataFixtures\Models;

use App\Chains\ChainOfCurrencyExchange\EuroStrategy;
use App\Contracts\Services\Wallet\WalletWithdrawCalculateManagerInterface as WalletWithdrawAction;
use App\Strategies\WithdrawRules\PrivateStrategy;

class WalletOperationArrayFixture
{
    public static function get(): array
    {
        return [
            '2020-10-20',
            1,
            PrivateStrategy::CLIENT_TYPE,
            WalletWithdrawAction::ACTION,
            10000,
            EuroStrategy::EURO,

        ];
    }
}
