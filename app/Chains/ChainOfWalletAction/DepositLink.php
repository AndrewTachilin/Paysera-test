<?php

declare(strict_types=1);

namespace App\Chains\ChainOfWalletAction;

use App\Contracts\Chains\ChainOfWalletActionInterface;
use App\Exceptions\Wallet\WalletActionException;
use App\Contracts\Services\Wallet\WalletDepositCalculateManagerInterface as WalletAction;
use App\Models\Actions\WalletOperation;

class DepositLink implements ChainOfWalletActionInterface
{
    protected WalletOperation $walletOperation;

    public function __construct(WalletOperation $walletOperation)
    {
        $this->walletOperation = $walletOperation;
    }

    public function detectTypeOfAction(): string
    {
        if (WalletAction::ACTION === $this->walletOperation->getActionType()) {
            return WalletAction::ACTION;
        }

        throw new WalletActionException('This action was not found in the system');
    }
}
