<?php

declare(strict_types=1);

namespace App\Services\Wallet;

use App\Contracts\Services\Wallet\WalletOperationsInterface;

class MathOperations implements WalletOperationsInterface
{
    public function roundToThousandths(string $amount): int
    {
        $amountInCoins = bcmul($amount, config('app.total_percent'));
        $roundToInteger = ceil((int) $amountInCoins);

        return intval($roundToInteger / (int) config('app.total_percent'));
    }

    public function calculateCommission(string $amount, string $percent): int
    {
        $percent = bcdiv($percent, config('app.total_percent'), 4);
        $percents = bcmul($amount, (string) $percent);

        return $this->roundToThousandths($percents);
    }

    public function convertCurrency(float $fromCurrency, float $rate): int
    {
        return (int) bcmul((string) $fromCurrency, (string) $rate);
    }

    public function convertToKopecks(string $amount): int
    {
        $amount = $this->roundToThousandths($amount);
        $kopecks = bcmul((string) $amount, config('app.total_percent'));

        return intval($kopecks);
    }
}
