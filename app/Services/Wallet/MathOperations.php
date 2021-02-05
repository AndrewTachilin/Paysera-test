<?php

declare(strict_types=1);

namespace App\Services\Wallet;

class MathOperations
{
    private const PERCENT = 100;

    public function roundToThousandths(float $number): string
    {
        $roundToInteger = ceil($number * self::PERCENT);

        $roundToThousand = $roundToInteger/self::PERCENT;

        return number_format($roundToThousand, 2);
    }

    public function calculateCommission(float $amount, float $percent): string
    {
        $percents = $amount * ($percent / self::PERCENT);

        return $this->roundToThousandths($percents);
    }

    public function convertCurrency(float $fromCurrency, float $rate): float
    {
        return $fromCurrency * $rate;
    }
}
