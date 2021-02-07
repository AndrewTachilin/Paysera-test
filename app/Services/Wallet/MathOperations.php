<?php

declare(strict_types=1);

namespace App\Services\Wallet;

class MathOperations
{
    public function roundToThousandths(float $number): string
    {
        $roundToInteger = ceil($number * (int) config('app.total_percent'));

        $roundToThousand = $roundToInteger/(int) config('app.total_percent');

        return number_format($roundToThousand, (int) config('app.numbers_after_dot'));
    }

    public function calculateCommission(float $amount, float $percent): string
    {
        $percents = $amount * ($percent / (int) config('app.total_percent'));

        return $this->roundToThousandths($percents);
    }

    public function convertCurrency(float $fromCurrency, float $rate): float
    {
        return $fromCurrency * $rate;
    }
}
