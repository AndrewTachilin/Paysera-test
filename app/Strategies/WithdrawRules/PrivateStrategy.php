<?php

declare(strict_types=1);

namespace App\Strategies\WithdrawRules;

use App\Contracts\Services\WithdrawRules\ClientTypeInterface;
use App\DataTransformer\WalletOperationDataTransformer;
use App\Exceptions\Wallet\WalletActionException;
use App\Models\Actions\WalletOperation;
use App\Services\CurrencyExchange\CurrencyExchangeService;
use App\Services\Wallet\MathOperations;
use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Collection;

class PrivateStrategy implements ClientTypeInterface
{
    private Client $client;

    private MathOperations $mathOperations;

    private CurrencyExchangeService $currencyExchange;

    private WalletOperationDataTransformer $dataTransformer;

    private $walletActionType;

    public function __construct(
        MathOperations $mathOperations,
        Client $client,
        CurrencyExchangeService $currencyExchanges,
        WalletOperationDataTransformer $dataTransformer
    ) {
        $this->mathOperations = $mathOperations;
        $this->client = $client;
        $this->currencyExchange = $currencyExchanges;
        $this->dataTransformer = $dataTransformer;
        $this->walletActionType = config('app.wallet_types.wallet_action_type_private');
    }

    public function getType(): string
    {
        return $this->walletActionType;
    }

    public function detectClientType(Collection $userHistories, WalletOperation $walletOperation): float
    {
        $commissionFee = 0.00;
        // search in collection by start and end date and user ids
        $result = $this->searchInCollectionByCriteria($userHistories, $walletOperation);

        $exchangedCurrency = $this->exchangeCurrency($walletOperation);
        $totalAmount = $this->getTotalAmountForUser($result, $exchangedCurrency);
        $countOfOperation = $result->count();

        /*
         * if total user's actions greater then defined value we take commission
         * if total user's withdraws greater then defined value we take commission
         */
        if ($totalAmount > config('app.limit_free_withdraw') || $countOfOperation > config('app.count_free_operation')) {
            $commissionFee = $this->mathOperations->calculateCommission(
                (string) $walletOperation->getActionAmount(),
                config('app.commission_private')
            );
        } else {
            $commissionFee = $this->mathOperations->calculateCommission(
                (string) $commissionFee,
                config('app.commission_private')
            );
        }

        $this->addUserHistory($walletOperation, $userHistories, $exchangedCurrency);

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

    /**
     * @param WalletOperation $walletOperation
     *
     * @return float
     *
     * @throws WalletActionException
     *
     * @throws \JsonException
     */
    private function exchangeCurrency(WalletOperation $walletOperation): float
    {
        $exchangeRates = $this->getExchangeRates();

        return $this->currencyExchange->exchange(
            $walletOperation->getCurrency(),
            $walletOperation->getActionAmount(),
            $exchangeRates
        );
    }

    protected function getTotalAmountForUser(
        Collection $filteredWithdraws,
        float $currentWithdraw,
        int $totalAmount = 0
    ): float {
        $filteredWithdraws->each(function (WalletOperation $item) use (&$totalAmount) {
            $totalAmount += $item->getActionAmount();
        });

        return $totalAmount + $currentWithdraw;
    }

    protected function addUserHistory(
        WalletOperation $walletOperation,
        Collection $userHistoryCollection,
        $exchangedCurrency = null
    ): void {
        $walletOperation = $this->dataTransformer->resetAmountWalletOperation($walletOperation, $exchangedCurrency);

        $userHistoryCollection->add($walletOperation);
    }

    private function getExchangeRates(): array
    {
        $request = new Request('GET', config('app.api_exchange_url'));
        $response = $this->client->send($request);

        try {
            return (array) json_decode($response->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR)['rates'];
        } catch (GuzzleException $exception) {
            throw new RequestException($exception->getMessage(), $request, $response, $exception);
        }
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
