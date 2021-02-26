<?php

declare(strict_types=1);

namespace App\Models\Actions;

use App\Contracts\Services\Wallet\WalletCalculateManagerInterface;
use Illuminate\Support\Collection;

class Calculation
{
    public WalletCalculateManagerInterface $walletAction;

    public WalletOperation $walletOperation;

    private Collection $userHistory;

    private array $exchangeRates;

    public function getWalletAction(): WalletCalculateManagerInterface
    {
        return $this->walletAction;
    }

    public function setWalletAction(WalletCalculateManagerInterface $walletAction): self
    {
        $this->walletAction = $walletAction;

        return $this;
    }

    public function getWalletOperation(): WalletOperation
    {
        return $this->walletOperation;
    }

    public function setWalletOperation(WalletOperation $walletOperation): Calculation
    {
        $this->walletOperation = $walletOperation;
        return $this;
    }

    public function getUserHistory(): Collection
    {
        return $this->userHistory;
    }

    public function setUserHistory(Collection $userHistory): Calculation
    {
        $this->userHistory = $userHistory;

        return $this;
    }

    public function getExchangeRates(): array
    {
        return $this->exchangeRates;
    }

    public function setExchangeRates(array $exchangeRates): Calculation
    {
        $this->exchangeRates = $exchangeRates;

        return $this;
    }
}
