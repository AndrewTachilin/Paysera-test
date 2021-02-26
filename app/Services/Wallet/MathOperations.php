<?php

declare(strict_types=1);

namespace App\Services\Wallet;

use App\Contracts\Services\Wallet\WalletOperationsInterface;

class MathOperations implements WalletOperationsInterface
{
    public function roundToThousandths(string $amount, int $scale = 0): string
    {
        $amountInCoins = $this->multiply($amount, config('app.total_percent'), $scale);

        return $this->divide($amountInCoins, config('app.total_percent'), $scale);
    }
    public function calculateCommission(string $amount, string $percent, int $scale = 0): string
    {
        $percent = $this->divide($percent, config('app.total_percent'), $scale);
        $percents = $this->multiply($amount, $percent, $scale);

        return $this->roundToThousandths($percents, $scale);
    }

    public function convertCurrency(string $fromCurrency, string $rate, int $scale = 0): string
    {
        return $this->multiply($fromCurrency, $rate, $scale);
    }

    public function convertToCoins(string $amount, int $scale = 0): string
    {
        $amount = $this->roundToThousandths($amount, $scale);

        return $this->multiply($amount, config('app.total_percent'), $scale);
    }

    public function multiply(string $leftOperand, string $rightOperand, int $scale = 0): string
    {
        return bcmul($leftOperand, $rightOperand, $scale);
    }

    public function divide(string $dividend, string $divisor, int $scale = 0): string
    {
        return bcdiv($dividend, $divisor, $scale);
    }

    public function fold(string $leftOperand, string $rightOperand, int $scale = 0): string
    {
        return bcadd($leftOperand, $rightOperand, $scale);
    }
}
