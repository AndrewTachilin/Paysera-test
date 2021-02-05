<?php

declare(strict_types=1);

namespace Tests\DataFixtures\Collections;

use Illuminate\Support\Collection;
use Tests\DataFixtures\Models\WithdrawBusinessWalletOperationFixture;

class WithdrawBusinessEurWalletOperationCollectionFixture
{
    public static function get(): Collection
    {
        return new Collection([WithdrawBusinessWalletOperationFixture::get()]);
    }
}
