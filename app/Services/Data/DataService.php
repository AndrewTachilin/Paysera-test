<?php

declare(strict_types=1);

namespace App\Services\Data;

use App\Contracts\Services\Data\DataServiceInterface;
use App\Contracts\Services\Wallet\WalletCalculateManagerInterface;
use App\Contracts\Strategies\ActionStrategyInterface;
use App\DataTransformer\CalculationDataTransformer;
use App\DataTransformer\WalletOperationDataTransformer;
use App\Exceptions\Currency\InvalidCurrencyException;
use App\Exceptions\Wallet\WalletActionException;
use App\Models\Actions\Calculation;
use App\Models\Actions\WalletOperation;
use Illuminate\Support\Collection;
use App\Exceptions\DataTransformer\UnableToTransformDataException;

class DataService implements DataServiceInterface
{
    /**
     * @var WalletCalculateManagerInterface[]
     */
    private $walletManager;

    /**
     * @var ActionStrategyInterface[]
     */
    private $typeAction;

    private Collection $userHistoryCollection;

    private WalletOperationDataTransformer $dataTransformer;


    private CalculationDataTransformer $calculationDataTransformer;

    public function __construct(
        WalletOperationDataTransformer $dataTransformer,
        CalculationDataTransformer $calculationDataTransformer,
        iterable $actionWallets,
        iterable $actionTypes
    ) {
        $this->calculationDataTransformer = $calculationDataTransformer;
        $this->dataTransformer = $dataTransformer;
        $this->userHistoryCollection = collect();
        /** @var WalletCalculateManagerInterface $actionWallet */
        foreach ($actionWallets as $actionWallet) {
            $this->walletManager[$actionWallet->getType()] = $actionWallet;
        }
        /** @var ActionStrategyInterface $actionType **/
        foreach ($actionTypes as $actionType) {
            $this->typeAction[$actionType->getType()] = $actionType;
        }
    }

    /**
     * @param array $walletOperation
     * @param array $exchangeRates
     * @return Calculation
     * @throws InvalidCurrencyException
     * @throws UnableToTransformDataException
     * @throws WalletActionException
     */
    public function prepareDataForCalculation(array $walletOperation, array $exchangeRates): Calculation
    {
        $walletOperation = $this->dataTransformer->transformFromArray($walletOperation);
        $this->isValidCurrency($walletOperation, $exchangeRates);
        $typeOfAction = $this->detectActionType($walletOperation);
        $walletAction = $this->detectWalletType($typeOfAction);

        return $this->calculationDataTransformer->collectDataForCommission(
            $this->userHistoryCollection,
            $exchangeRates,
            $walletAction,
            $walletOperation
        );
    }

    private function isValidCurrency(WalletOperation $walletOperation, array $exchangeRates): void
    {
        $isCurrencyExist = array_key_exists($walletOperation->getCurrency(), $exchangeRates);

        if (!$isCurrencyExist && $walletOperation->getCurrency() !== config('app.currencies.default_currency')) {
            throw new InvalidCurrencyException('Currency is invalid');
        }
    }

    private function detectActionType(WalletOperation $walletOperation): ActionStrategyInterface
    {
        $typeOfAction = $this->typeAction[$walletOperation->getActionType()] ?? null;

        if ($typeOfAction === null) {
            throw new WalletActionException('This action was not found in the system');
        }

        return $typeOfAction;
    }

    private function detectWalletType(ActionStrategyInterface $typeOfAction): WalletCalculateManagerInterface
    {
        $walletAction = $this->walletManager[$typeOfAction->getType()] ?? null;

        if ($walletAction === null) {
            throw new WalletActionException('This type of action was not found in the system');
        }

        return $walletAction;
    }
}
