<?php

declare(strict_types=1);

namespace App\Services\Wallet;

use App\Contracts\Services\Wallet\WalletDepositCalculateManagerInterface;
use App\Models\Actions\WalletOperation;
use Illuminate\Support\Collection;

class WalletDepositCalculateService implements WalletDepositCalculateManagerInterface
{
    private MathOperations $mathOperations;

    public function __construct(MathOperations $mathOperations)
    {
        $this->mathOperations = $mathOperations;
    }

    public function getType(): string
    {
        return self::ACTION;
    }

    public function calculateCommissionFee(WalletOperation $walletOperation, Collection $userHistories): float
    {
        return $this->mathOperations->calculateCommission(
            (string) $walletOperation->getActionAmount(),
            config('app.commission_deposit')
        );
    }
}
