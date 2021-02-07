<?php

declare(strict_types=1);

namespace App\DataTransformer;

use App\Contracts\DataTransformer\WalletOperationDataTransformerInterface;
use App\Exceptions\ValidationException\ValidationException;
use App\Models\Actions\WalletOperation;
use Carbon\Carbon;
use Symfony\Component\HttpFoundation\Response;

class WalletOperationDataTransformer implements WalletOperationDataTransformerInterface
{
    public function transformFromArray(array $walletOperation): WalletOperation
    {
        try {
            $walletOperation = (new WalletOperation())
                ->setDateOfAction(Carbon::createFromFormat('Y-m-d', $walletOperation[0])->format('Y-m-d'))
                ->setUserId((int) $walletOperation[1])
                ->setClientType($walletOperation[2])
                ->setActionType($walletOperation[3])
                ->setActionAmount((int) $walletOperation[4])
                ->setCurrency($walletOperation[5]);
        } catch (\Throwable $e) {
            throw new ValidationException('Invalid data was passed', Response::HTTP_BAD_REQUEST);
        }

        return $walletOperation;
    }

    public function resetAmountWalletOperation(WalletOperation $walletOperation, float $amount = null): WalletOperation
    {
        return (new WalletOperation())
            ->setDateOfAction($walletOperation->getDateOfAction())
            ->setUserId($walletOperation->getUserId())
            ->setClientType($walletOperation->getClientType())
            ->setActionType($walletOperation->getActionType())
            ->setActionAmount((int)($amount) ?? (int)($walletOperation->getActionAmount()))
            ->setCurrency($walletOperation->getCurrency());
    }
}
