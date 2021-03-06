<?php

declare(strict_types=1);

namespace Tests\DataFixtures\Collections;

use Illuminate\Support\Collection;
use Tests\DataFixtures\Models\WithdrawPrivateEurWalletOperationFixture;

class WithdrawPrivateUserMadeFourActionCollection
{
    public static function get(): Collection
    {
        return new Collection([
            WithdrawPrivateEurWalletOperationFixture::get(),
            WithdrawPrivateEurWalletOperationFixture::get(),
            WithdrawPrivateEurWalletOperationFixture::get(),
            WithdrawPrivateEurWalletOperationFixture::get(),
        ]);
    }
}
