<?php

declare(strict_types=1);

namespace App\Services\Wallet;

use App\Contracts\Services\Wallet\WalletCalculateManagerInterface;
use App\Models\Actions\WalletOperation;
use Illuminate\Support\Collection;

class WalletDepositCalculateService implements WalletCalculateManagerInterface
{
    private MathOperations $mathOperations;

    public function __construct(MathOperations $mathOperations)
    {
        $this->mathOperations = $mathOperations;
    }

    public function getType(): string
    {
        return config('app.wallet_action_deposit');
    }

    public function calculateCommissionFee(WalletOperation $walletOperation, Collection $userHistories): float
    {
        return $this->mathOperations->calculateCommission(
            (string) $walletOperation->getActionAmount(),
            config('app.commission_deposit')
        );
    }
}
