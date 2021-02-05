<?php

declare(strict_types=1);

namespace Tests\DataFixtures\Collections;

use Illuminate\Support\Collection;
use Tests\DataFixtures\Models\WithdrawPrivateEurHighWalletOperationFixture;

class WithdrawPrivateHighAmountActionCollection
{
    public static function get(): Collection
    {
        return new Collection([
            WithdrawPrivateEurHighWalletOperationFixture::get(),
        ]);
    }
}
