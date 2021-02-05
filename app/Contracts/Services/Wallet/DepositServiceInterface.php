<?php

namespace App\Contracts\Services\Wallet;

interface DepositServiceInterface extends WalletInterface
{
    public function parseFile(string $path);
}
