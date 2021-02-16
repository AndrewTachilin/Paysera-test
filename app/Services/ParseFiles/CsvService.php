<?php

declare(strict_types=1);

namespace App\Services\ParseFiles;

use App\Contracts\Strategies\ActionStrategyInterface;
use App\DataTransformer\WalletOperationDataTransformer;
use App\Exceptions\ParseFile\ParseFileException;
use App\Contracts\Services\ParseFiles\ParseFileInterface;
use App\Exceptions\File\FileInvalidException;
use App\Exceptions\File\FileNotFoundException;
use App\Contracts\Services\Wallet\WalletCalculateManagerInterface;
use App\Exceptions\Wallet\WalletActionException;
use App\Services\Wallet\MathOperations;
use Illuminate\Support\Collection;
use Symfony\Component\HttpFoundation\Response;

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

    public function __construct(
        WalletOperationDataTransformer $dataTransformer,
        iterable $actionWallets,
        iterable $actionTypes
    ) {
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

    public function parseFile(string $fileName): array
    {
        $filePath = $this->getFilePath($fileName);
        $this->isFileValid($filePath, $fileName);
        $result = [];

        try {
            $lines = $this->readFile($filePath);

            foreach ($lines as $walletOperation) {
                $walletOperation = (new WalletOperationDataTransformer(new MathOperations()))->transformFromArray($walletOperation);
                $typeOfAction = $this->typeAction[$walletOperation->getActionType()] ?? null;

                if (empty($typeOfAction)) {
                    throw new WalletActionException('This action was not found in the system');
                }
                $walletAction = $this->walletManager[$typeOfAction->getType()] ?? null;

                if (empty($walletAction)) {
                    throw new WalletActionException('This type of action was not found in the system');
                }
                $percent = $walletAction->calculateCommissionFee(
                    $walletOperation,
                    $this->userHistoryCollection
                );

                $result[] = $percent;
            }
        } catch (\Throwable $e) {
            throw new ParseFileException($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }

        return $result;
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
            throw new FileNotFoundException('File not found', Response::HTTP_NOT_FOUND);
        }

        return $filePath;
    }

    private function isExtensionValid(string $fileName): void
    {
        $parsedFileName = explode('.', $fileName);

        if (empty($parsedFileName)) {
            throw new FileInvalidException('File is not valid', Response::HTTP_BAD_REQUEST);
        }

        $fileExtension = last($parsedFileName);

        if (strcasecmp($fileExtension, self::VALID_FILE_EXTENSION)) {
            throw new FileInvalidException('Invalid File extension ', Response::HTTP_BAD_REQUEST);
        }
    }

    public function getFilePath(string $fileName): string
    {
        return sprintf('%s/%s', storage_path('import'), $fileName);
    }
}
