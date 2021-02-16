<?php

declare(strict_types=1);

namespace App\Services\Wallet;

class MathOperations
{
    public function roundToThousandths(string $number): float
    {
        $roundToInteger = ceil($number * (int) config('app.total_percent'));

        return $roundToInteger/(int) config('app.total_percent');
    }

    public function calculateCommission(string $amount, string $percent): float
    {
        $percent = $percent / (int) config('app.total_percent');

        $percents = bcmul($amount, (string) $percent);

        return $this->roundToThousandths($percents);
    }

    public function convertCurrency(float $fromCurrency, float $rate): float
    {
        return $fromCurrency * $rate;
    }

    public function convertToKopecks(string $amount): int
    {
        $amount = $this->roundToThousandths($amount);

        return (int) bcmul((string) $amount, config('app.total_percent'));
    }
}
