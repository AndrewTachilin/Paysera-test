<?php

declare(strict_types=1);

namespace App\Strategies\WithdrawRules;

use App\Contracts\Services\WithdrawRules\ClientTypeInterface;
use App\DataTransformer\WalletOperationDataTransformer;
use App\Models\Actions\WalletOperation;
use App\Services\CurrencyExchange\CurrencyExchangeService;
use App\Services\Wallet\MathOperations;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class PrivateStrategy implements ClientTypeInterface
{
    private MathOperations $mathOperations;

    private CurrencyExchangeService $currencyExchange;

    private WalletOperationDataTransformer $dataTransformer;

    private $walletActionType;

    public function __construct(
        MathOperations $mathOperations,
        CurrencyExchangeService $currencyExchanges,
        WalletOperationDataTransformer $dataTransformer
    ) {
        $this->mathOperations = $mathOperations;
        $this->currencyExchange = $currencyExchanges;
        $this->dataTransformer = $dataTransformer;
        $this->walletActionType = config('app.wallet_types.wallet_action_type_private');
    }

    public function getType(): string
    {
        return $this->walletActionType;
    }

    public function calculateCommission(
        Collection $userHistories,
        WalletOperation $walletOperation,
        array $exchangeCurrency
    ): string {
        $commissionFee = '0';
        // search in collection by start and end date and user ids
        $result = $this->searchInCollectionByCriteria($userHistories, $walletOperation);
        $exchangedCurrency = $this->exchangeCurrency($walletOperation, $exchangeCurrency);
        $totalAmount = $this->getTotalAmountForUser($result, $exchangedCurrency);
        $countOfOperation = $result->count();

        /*
         * if total user's actions greater then defined value we take commission
         * if total user's withdraws greater then defined value we take commission
         */
        if ($totalAmount > config('app.limit_free_withdraw') || $countOfOperation > config('app.count_free_operation')) {
            $commissionFee = $this->mathOperations->calculateCommission(
                $walletOperation->getActionAmount(),
                config('app.commission_private'),
                (int) config('app.scale')
            );
        } else {
            $commissionFee = $this->mathOperations->calculateCommission(
                $commissionFee,
                config('app.commission_private'),
                (int) config('app.scale')
            );
        }
        $this->storeUserHistory($walletOperation, $userHistories, $exchangedCurrency);

        return $commissionFee;
    }

    private function searchInCollectionByCriteria(Collection $userHistories, WalletOperation $walletOperation): Collection
    {
        return $userHistories->whereBetween(
            'dateOfAction',
            [
                $this->getStartDayOfWeek($walletOperation),
                $this->getEndDayOfWeek($walletOperation)
            ]
        )->where('userId', '=', $walletOperation->getUserId());
    }

    private function exchangeCurrency(WalletOperation $walletOperation, array $exchangeRates): string
    {
        return $this->currencyExchange->exchange(
            $walletOperation->getCurrency(),
            $walletOperation->getActionAmount(),
            $exchangeRates
        );
    }

    protected function getTotalAmountForUser(
        Collection $filteredWithdraws,
        string $currentWithdraw
    ): string {
        $totalAmount = '';
        $filteredWithdraws->each(function (WalletOperation $item) use (&$totalAmount) {
            $totalAmount = $this->mathOperations->fold($totalAmount, $item->getActionAmount());
        });

        return $this->mathOperations->fold($totalAmount, $currentWithdraw);
    }

    protected function storeUserHistory(
        WalletOperation $walletOperation,
        Collection $userHistoryCollection,
        $exchangedCurrency = null
    ): void {
        $walletOperation = $this->dataTransformer->resetAmountWalletOperation($walletOperation, $exchangedCurrency);

        $userHistoryCollection->add($walletOperation);
    }

    private function getStartDayOfWeek(WalletOperation $walletOperation): string
    {
        return Carbon::createFromFormat(
            config('app.date_time_format'),
            $walletOperation
                ->getDateOfAction()
        )
         ->startOfWeek()
         ->format(config('app.date_time_format'));
    }

    private function getEndDayOfWeek(WalletOperation $walletOperation): string
    {
        return Carbon::createFromFormat(
            config('app.date_time_format'),
            $walletOperation->getDateOfAction()
        )
        ->endofWeek()
        ->format(config('app.date_time_format'));
    }
}
