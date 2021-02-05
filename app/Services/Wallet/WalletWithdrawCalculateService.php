<?php

declare(strict_types=1);

namespace App\Services\Wallet;

use App\Chains\ChainOfWithdrawRules\BusinessLink;
use App\Contracts\Services\Wallet\WalletWithdrawCalculateManagerInterface;
use App\Models\Actions\WalletOperation;
use GuzzleHttp\Client;
use Illuminate\Support\Collection;

/**
 * Class WalletDepositCalculateService
 * @package App\Servicess\Wallet
 */
class WalletWithdrawCalculateService implements WalletWithdrawCalculateManagerInterface
{
    private MathOperations $mathOperations;

    protected Client $client;

    public function __construct(MathOperations $mathOperations, Client $client)
    {
        $this->mathOperations = $mathOperations;
        $this->client = $client;
    }

    public function getType(): string
    {
        return self::ACTION;
    }

    public function calculateCommissionFee(WalletOperation $walletOperation, Collection $userHistories): array
    {
        return (new BusinessLink($walletOperation, $this->mathOperations, $this->client))->detectClientType($userHistories);
    }
}
