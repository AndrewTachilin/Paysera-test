<?php

declare(strict_types=1);

namespace App\Services\Wallet;

use App\Contracts\Services\Wallet\WalletDepositCalculateManagerInterface;
use App\Models\Actions\WalletOperation;
use Illuminate\Support\Collection;

class WalletDepositCalculateService extends MathOperations implements WalletDepositCalculateManagerInterface
{
    private const COMMISSION_FEE = 0.03;

    public function getType(): string
    {
        return self::ACTION;
    }

    public function calculateCommissionFee(WalletOperation $walletOperation, Collection $userHistories): array
    {
        $percents = $this->calculateCommission($walletOperation->getActionAmount(), self::COMMISSION_FEE);

        return  [$percents, $userHistories];
    }
}
