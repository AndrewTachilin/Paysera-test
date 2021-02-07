<?php

declare(strict_types=1);

namespace App\Chains\ChainOfWalletAction;

use App\Contracts\Services\Wallet\WalletWithdrawCalculateManagerInterface as WalletAction;
use App\Exceptions\Wallet\WalletActionException;

class WithdrawLink extends DepositLink
{
    /**
     * @return string
     *
     * @throws WalletActionException
     */
    public function detectTypeOfAction(): string
    {
        if (WalletAction::ACTION === $this->walletOperation->getActionType()) {
            return WalletAction::ACTION;
        }

        return parent::detectTypeOfAction();
    }
}
