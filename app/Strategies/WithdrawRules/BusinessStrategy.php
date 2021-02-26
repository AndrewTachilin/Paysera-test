<?php

declare(strict_types=1);

namespace App\Strategies\WithdrawRules;

use App\Contracts\Services\WithdrawRules\ClientTypeInterface;
use App\DataTransformer\WalletOperationDataTransformer;
use App\Models\Actions\WalletOperation;
use App\Services\Wallet\MathOperations;
use Illuminate\Support\Collection;

class BusinessStrategy implements ClientTypeInterface
{
    private MathOperations $mathOperations;

    private WalletOperationDataTransformer $dataTransformer;

    public function __construct(MathOperations $mathOperations, WalletOperationDataTransformer $dataTransformer)
    {
        $this->mathOperations = $mathOperations;
        $this->dataTransformer = $dataTransformer;
    }

    public function getType(): string
    {
        return config('app.wallet_types.wallet_action_type_business');
    }

    public function calculateCommission(
        Collection $userHistories,
        WalletOperation $walletOperation,
        array $exchangeCurrency
    ): string {
        $commissionFee = $this->mathOperations->calculateCommission(
            $walletOperation->getActionAmount(),
            config('app.commission_business_withdraw'),
            (int) config('app.scale')
        );

        $this->storeUserHistory($walletOperation, $userHistories);

        return $commissionFee;
    }

    private function storeUserHistory(
        WalletOperation $walletOperation,
        Collection $userHistoryCollection,
        $exchangedCurrency = null
    ): void {
        $walletOperation = $this->dataTransformer->resetAmountWalletOperation($walletOperation, $exchangedCurrency);
        $userHistoryCollection->add($walletOperation);
    }
}
