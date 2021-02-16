<?php

declare(strict_types=1);

namespace App\Strategies\WalletAction;

use App\Contracts\Strategies\WithdrawStrategyInterface;
use App\Exceptions\Wallet\WalletActionException;
use App\Models\Actions\WalletOperation;

class WithdrawStrategy implements WithdrawStrategyInterface
{
    protected WalletOperation $walletOperation;

    public function __construct(WalletOperation $walletOperation)
    {
        $this->walletOperation = $walletOperation;
    }

    public function getType(): string
    {
        return self::TYPE;
    }

    public function detectTypeOfAction(): string
    {
        if (self::TYPE  === $this->walletOperation->getActionType()) {
            return self::TYPE;
        }

        throw new WalletActionException('This action was not found in the system');
    }
}
