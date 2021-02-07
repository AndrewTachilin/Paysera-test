<?php

declare(strict_types=1);

namespace App\Strategies\WithdrawRules;

use App\Contracts\Strategies\BusinessStrategyInterface;
use App\DataTransformer\WalletOperationDataTransformer;
use App\Models\Actions\WalletOperation;
use App\Services\Wallet\MathOperations;
use Illuminate\Support\Collection;

class BusinessStrategy implements BusinessStrategyInterface
{
    private MathOperations $mathOperations;

    public function __construct(MathOperations $mathOperations)
    {
        $this->mathOperations = $mathOperations;
    }

    public function getType(): string
    {
        return self::CLIENT_TYPE;
    }

    public function detectClientType(Collection $userHistories, WalletOperation $walletOperation): string
    {
        $commissionFee = $this->mathOperations->calculateCommission(
            $walletOperation->getActionAmount(),
            (float) config('app.commission_business_withdraw')
        );

        $this->addUserHistory($walletOperation, $userHistories);

        return $commissionFee;
    }

    private function addUserHistory(
        WalletOperation $walletOperation,
        Collection $userHistoryCollection,
        $exchangedCurrency = null
    ): void {
        $walletOperation = (new WalletOperationDataTransformer())
            ->resetAmountWalletOperation($walletOperation, $exchangedCurrency);

        $userHistoryCollection->add($walletOperation);
    }
}
