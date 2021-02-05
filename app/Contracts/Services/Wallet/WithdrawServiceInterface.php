<?php

namespace App\Contracts\Services\Wallet;

interface WithdrawServiceInterface extends WalletInterface
{
    public function parseFile(string $path);
}
