<?php

declare(strict_types=1);

namespace App\Chains\ChainOfWithdrawRules;

use App\Chains\ChainOfCurrencyExchange\JpyLink;
use App\Contracts\Chains\ChainOfWithdrawLinkActionInterface;
use App\DataTransformer\WalletOperationDataTransformer;
use App\Exceptions\UnavailableService\UnavailableServiceException;
use App\Models\Actions\WalletOperation;
use App\Services\Wallet\MathOperations;
use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Collection;

class PrivateLink implements ChainOfWithdrawLinkActionInterface
{
    public const CLIENT_TYPE = 'private';

    private const COMMISSION_FEE = 0.3;

    private const LIMIT_FREE_WITHDRAW = 1000;

    private const COUNT_FREE_OPERATION = 3;

    protected WalletOperation $walletOperation;

    /** @var string|float **/
    protected $commissionFee = 0.00;

    private Client $client;

    protected MathOperations $mathOperations;

    private const HTTP_URL = 'https://api.exchangeratesapi.io/latest';

    private const DATE_FORMAT = 'Y-m-d';

    public function __construct(
        WalletOperation $walletOperation,
        MathOperations $mathOperations,
        Client $client
    ) {
        $this->walletOperation = $walletOperation;
        $this->mathOperations = $mathOperations;
        $this->client = $client;
    }

    public function detectClientType(Collection $userHistories): array
    {
        if (self::CLIENT_TYPE === $this->walletOperation->getClientType()) {

            // search in collection by start and end date and user ids
            $result = $userHistories->whereBetween(
                'dateOfAction',
                [
                    $this->getStartDayOfWeek(),
                    $this->getEndDayOfWeek()
                ]
            )->where('userId', '=', $this->walletOperation->getUserId());


            $exchangedCurrency = $this->exchangeCurrency();


            $totalAmount = $this->getTotalAmountForUser($result, $exchangedCurrency);
            $countOfOperation = $result->count();

            /*
             * if total user's actions greater then defined value we take commission
             * if total user's withdraws greater then defined value we take commission
             */
            if ($totalAmount > self::LIMIT_FREE_WITHDRAW || $countOfOperation > self::COUNT_FREE_OPERATION) {
                $this->commissionFee = $this->mathOperations->calculateCommission(
                    $this->walletOperation->getActionAmount(),
                    self::COMMISSION_FEE
                );
            } else {
                $this->commissionFee = $this->mathOperations->calculateCommission(
                    $this->commissionFee,
                    self::COMMISSION_FEE
                );
            }

            $this->addUserHistory($this->walletOperation, $userHistories, $exchangedCurrency);
        }

        return [$this->commissionFee, $userHistories];
    }

    private function exchangeCurrency(): float
    {
        $exchangeRates = $this->getExchangeRates();

        return (new JpyLink($exchangeRates))->exchange(
            $this->walletOperation->getCurrency(),
            $this->walletOperation->getActionAmount()
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
        Collection &$userHistoryCollection,
        $exchangedCurrency = null
    ): void {
        $walletOperation = (new WalletOperationDataTransformer())
            ->resetAmountWalletOperation($walletOperation, $exchangedCurrency);

        $userHistoryCollection->add($walletOperation);
    }

    private function getExchangeRates(): array
    {
        try {
            $response = $this->client->send(new Request('GET', self::HTTP_URL));
            $exchangeRates = (array) json_decode($response->getBody()->getContents())->rates;
        } catch (\Exception $exception) {
            throw new UnavailableServiceException($exception->getMessage(), $exception->getCode());
        }

        return $exchangeRates;
    }

    private function getStartDayOfWeek(): string
    {
        return Carbon::createFromFormat(
            self::DATE_FORMAT,
            $this->walletOperation
                ->getDateOfAction()
        )
         ->startOfWeek()
         ->format(self::DATE_FORMAT);
    }

    private function getEndDayOfWeek(): string
    {
        return Carbon::createFromFormat(
            self::DATE_FORMAT,
            $this->walletOperation->getDateOfAction()
        )
            ->endofWeek()
            ->format(self::DATE_FORMAT);
    }
}
