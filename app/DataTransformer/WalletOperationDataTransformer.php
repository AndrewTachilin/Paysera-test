<?php

declare(strict_types=1);

namespace App\DataTransformer;

use App\Contracts\DataTransformer\WalletOperationDataTransformerInterface;
use App\Exceptions\DataTransformer\UnableToTransformDataException;
use App\Models\Actions\WalletOperation;
use App\Services\Wallet\MathOperations;
use Carbon\Carbon;

class WalletOperationDataTransformer implements WalletOperationDataTransformerInterface
{
    private MathOperations $mathOperation;

    public function __construct(MathOperations $mathOperation)
    {
        $this->mathOperation = $mathOperation;
    }

    public function transformFromArray(array $walletOperation): WalletOperation
    {
        try {
            $amount = $this->mathOperation->convertToCoins($walletOperation[4]);
            $walletOperation = (new WalletOperation())
                ->setDateOfAction(Carbon::createFromFormat('Y-m-d', $walletOperation[0])->format('Y-m-d'))
                ->setUserId((int) $walletOperation[1])
                ->setClientType($walletOperation[2])
                ->setActionType($walletOperation[3])
                ->setActionAmount($amount)
                ->setCurrency($walletOperation[5]);
        } catch (\Throwable $e) {
            throw new UnableToTransformDataException('Invalid data was passed');
        }

        return $walletOperation;
    }

    public function resetAmountWalletOperation(WalletOperation $walletOperation, ?string $amount = ''): WalletOperation
    {
        return (new WalletOperation())
            ->setDateOfAction($walletOperation->getDateOfAction())
            ->setUserId($walletOperation->getUserId())
            ->setClientType($walletOperation->getClientType())
            ->setActionType($walletOperation->getActionType())
            ->setActionAmount((string)($amount) ?? (string)($walletOperation->getActionAmount()))
            ->setCurrency($walletOperation->getCurrency());
    }
}
