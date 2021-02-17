<?php

declare(strict_types=1);

namespace Tests\DataFixtures\Models;

use App\Strategies\WithdrawRules\PrivateStrategy;

class WalletOperationArrayFixture
{
    public static function get(): array
    {
        return [
            '2020-10-20',
            1,
            PrivateStrategy::CLIENT_TYPE,
            config('app.wallet_action_withdraw'),
            '10000',
            config('app.default_currency'),

        ];
    }
}
