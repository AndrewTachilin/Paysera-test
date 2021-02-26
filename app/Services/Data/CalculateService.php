<?php

declare(strict_types=1);

namespace App\Services\Data;

use App\Contracts\Services\Data\CalculateServiceInterface;
use App\Contracts\Services\Data\DataServiceInterface;
use App\Exceptions\ParseFile\ParseFileException;
use App\Requests\CurrencyExchange\CurrencyExchangeApiRequest;

class CalculateService implements CalculateServiceInterface
{
    private CurrencyExchangeApiRequest $exchangeApiRequest;

    private DataServiceInterface $dataService;

    private CalculateCommissionService $calculationService;

    public function __construct(
        CurrencyExchangeApiRequest $exchangeApiRequest,
        DataServiceInterface $dataService,
        CalculateCommissionService $calculationService
    ) {
        $this->exchangeApiRequest = $exchangeApiRequest;
        $this->dataService = $dataService;
        $this->calculationService = $calculationService;
    }

    public function calculate(array $lines): array
    {
        $exchangeRates = $this->exchangeApiRequest->getRates();
        $result = [];

        try {
            foreach ($lines as $walletOperation) {
                $preparedData = $this->dataService->prepareDataForCalculation($walletOperation, $exchangeRates);
                $result[] = $this->calculationService->calculateCommission($preparedData);
            }
        } catch (\Throwable $e) {
            throw new ParseFileException($e->getMessage());
        }

        return $result;
    }
}
