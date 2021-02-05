<?php

declare(strict_types=1);

namespace App\Contracts\DataTransformer;

use App\Models\Actions\WalletOperation;

interface WalletOperationDataTransformerInterface
{
    public function transformFromArray(array $walletAction): WalletOperation;

    public function resetAmountWalletOperation(WalletOperation $walletOperation, float $amount = null): WalletOperation;
}
