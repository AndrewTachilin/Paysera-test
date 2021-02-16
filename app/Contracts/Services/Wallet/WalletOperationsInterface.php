<?php

declare(strict_types=1);

namespace App\Contracts\Services\Wallet;


interface WalletOperationsInterface
{
    public function roundToThousandths(string $amount): int;

    public function calculateCommission(string $amount, string $percent): int;

    public function convertCurrency(float $fromCurrency, float $rate): int;

    public function convertToKopecks(string $amount): int;
}
