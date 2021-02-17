<?php

declare(strict_types=1);

namespace Tests\DataFixtures\Models;

class WalletOperationArrayFixture
{
    public static function get(): array
    {
        return [
            '2020-10-20',
            1,
            config('app.wallet_types.wallet_action_type_private'),
            config('app.wallet_actions.wallet_action_withdraw'),
            '10000',
            config('app.currencies.default_currency'),

        ];
    }
}
