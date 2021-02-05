<?php

declare(strict_types=1);

namespace Tests\DataFixtures\Collections;

use Illuminate\Support\Collection;
use Tests\DataFixtures\Models\DepositPrivateWalletOperationFixture;

class DepositPrivateWalletOperationCollectionFixture
{
    public static function get(): Collection
    {
        return new Collection([DepositPrivateWalletOperationFixture::get()]);
    }
}
