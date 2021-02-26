<?php

declare(strict_types=1);

namespace App\Services\ParseFiles;

use App\Contracts\Strategies\ActionStrategyInterface;
use App\DataTransformer\WalletOperationDataTransformer;
use App\Exceptions\Currency\InvalidCurrencyException;
use App\Exceptions\ParseFile\ParseFileException;
use App\Contracts\Services\ParseFiles\ParseFileInterface;
use App\Exceptions\File\FileInvalidException;
use App\Exceptions\File\FileNotFoundException;
use App\Contracts\Services\Wallet\WalletCalculateManagerInterface;
use App\Exceptions\Wallet\WalletActionException;
use App\Models\Actions\WalletOperation;
use App\Requests\CurrencyExchange\CurrencyExchangeApiRequest;
use Illuminate\Support\Collection;

class CsvService implements ParseFileInterface
{
    private const VALID_FILE_EXTENSION = 'csv';

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

    private CurrencyExchangeApiRequest $exchangeApiRequest;

    public function __construct(
        CurrencyExchangeApiRequest $exchangeApiRequest,
        WalletOperationDataTransformer $dataTransformer,
        iterable $actionWallets,
        iterable $actionTypes
    ) {
        $this->exchangeApiRequest = $exchangeApiRequest;
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


    public function isValid($fileName): void
    {
        $filePath = $this->getFilePath($fileName);
        $this->isFileValid($filePath, $fileName);
    }
    public function parseFile(string $fileName): array
    {
        $filePath = $this->getFilePath($fileName);
        $exchangeRates = $this->exchangeApiRequest->getRates();
        $result = [];
        try {
            $lines = $this->readFile($filePath);

            foreach ($lines as $walletOperation) {
                $walletOperation = $this->dataTransformer->transformFromArray($walletOperation);
                $this->isValidCurrency($walletOperation, $exchangeRates);
                $typeOfAction = $this->detectActionType($walletOperation);
                $walletAction = $this->detectWalletType($typeOfAction);
                $percent = $walletAction->calculateCommissionFee(
                    $walletOperation,
                    $this->userHistoryCollection,
                    $exchangeRates
                );

                $result[] = $percent;
            }
        } catch (\Throwable $e) {
            throw new ParseFileException($e->getMessage());
        }

        return $result;
    }

    private function isValidCurrency(WalletOperation $walletOperation, array $exchangeRates): void
    {
        $isCurrencyExist = key_exists($walletOperation->getCurrency(), $exchangeRates);

        if (!$isCurrencyExist && $walletOperation->getCurrency() != config('app.currencies.default_currency')) {
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

    private function readFile(string $filePath): \Generator
    {
        $file = fopen($filePath, 'rb+');

        while (($walletOperation = fgetcsv($file)) !== false) {
            if (empty($walletOperation[0])) {
                continue;
            }
            yield $walletOperation;
        }

        fclose($file);
    }

    private function isFileValid(string $filePath, string $fileName): void
    {
        $this->isPathValid($filePath);
        $this->isExtensionValid($fileName);
    }

    private function isPathValid(string $filePath): string
    {
        if (!file_exists($filePath)) {
            throw new FileNotFoundException('File not found');
        }

        return $filePath;
    }

    private function isExtensionValid(string $fileName): void
    {
        $parsedFileName = explode('.', $fileName);

        if (empty($parsedFileName)) {
            throw new FileInvalidException('File is not valid');
        }

        $fileExtension = last($parsedFileName);

        if (strcasecmp($fileExtension, self::VALID_FILE_EXTENSION)) {
            throw new FileInvalidException('Invalid File extension ');
        }
    }

    public function getFilePath(string $fileName): string
    {
        return sprintf('%s/%s', storage_path('import'), $fileName);
    }
}
