<?php

declare(strict_types=1);

namespace App\Contracts\Services\Wallet;

interface WalletOperationsInterface
{
    public function roundToThousandths(string $amount): string;

    public function calculateCommission(string $amount, string $percent): string;

    public function convertCurrency(string $fromCurrency, string $rate): string;

    public function convertToCoins(string $amount): string;

    public function fold(string $leftOperand, string $rightOperand, int $scale = 0): string;

    public function multiply(string $leftOperand, string $rightOperand, int $scale = 0): string;

    public function divide(string $dividend, string $divisor, int $scale = 0): string;
}
