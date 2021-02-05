<?php

declare(strict_types=1);

namespace App\Chains\ChainOfWithdrawRules;

use Illuminate\Support\Collection;

class BusinessLink extends PrivateLink
{
    public const CLIENT_TYPE = 'business';

    private const COMMISSION_FEE = 0.5;

    public function detectClientType(Collection $userHistories): array
    {
        if (self::CLIENT_TYPE === $this->walletOperation->getClientType()) {
            $this->commissionFee = $this->mathOperations->calculateCommission(
                $this->walletOperation->getActionAmount(),
                self::COMMISSION_FEE
            );

            $this->addUserHistory($this->walletOperation, $userHistories);

            return [$this->commissionFee, $userHistories];
        }

        return parent::detectClientType($userHistories);
    }
}
