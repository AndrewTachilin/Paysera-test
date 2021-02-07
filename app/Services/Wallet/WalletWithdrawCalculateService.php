<?php

declare(strict_types=1);

namespace App\Services\Wallet;

use App\Contracts\Services\Wallet\WalletWithdrawCalculateManagerInterface;
use App\Contracts\Services\WithdrawRules\ClientTypeInterface;
use App\Exceptions\ValidationException\ClientTypeException;
use App\Models\Actions\WalletOperation;
use Illuminate\Support\Collection;

/**
 * Class WalletDepositCalculateService
 * @package App\Servicess\Wallet
 */
class WalletWithdrawCalculateService implements WalletWithdrawCalculateManagerInterface
{
    /** @var ClientTypeInterface[] */
    private $clientTypes;

    public function __construct(iterable $clientTypes)
    {
        /** @var ClientTypeInterface $clientType */
        foreach ($clientTypes as $clientType) {
            $this->clientTypes[$clientType->getType()] = $clientType;
        }
    }

    public function getType(): string
    {
        return self::ACTION;
    }

    public function calculateCommissionFee(WalletOperation $walletOperation, Collection $userHistories): string
    {
        $clientType = $this->clientTypes[$walletOperation->getClientType()] ?? null;
        if (null === $clientType) {
            throw new ClientTypeException('Invalid client type');
        }

        return $clientType->detectClientType($userHistories, $walletOperation);
    }
}
