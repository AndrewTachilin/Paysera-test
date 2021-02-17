<?php

declare(strict_types=1);

namespace App\Strategies\WalletAction;

use App\Contracts\Strategies\ActionStrategyInterface;
use App\Exceptions\Wallet\WalletActionException;
use App\Models\Actions\WalletOperation;

class DepositStrategy implements ActionStrategyInterface
{
    protected WalletOperation $walletOperation;

    private string $walletAction;
    public function __construct(WalletOperation $walletOperation)
    {
        $this->walletOperation = $walletOperation;
        $this->walletAction = config('app.wallet_actions.wallet_action_deposit');
    }

    public function getType(): string
    {
        return $this->walletAction;
    }

    public function detectTypeOfAction(): string
    {
        if ($this->walletAction  === $this->walletOperation->getActionType()) {
            return $this->walletAction;
        }

        throw new WalletActionException('This action was not found in the system');
    }
}
