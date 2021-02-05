<?php

declare(strict_types=1);

namespace App\Services\ParseFiles;

use App\DataTransformer\WalletOperationDataTransformer;
use App\Exceptions\Wallet\WalletActionException;
use App\Chains\ChainOfWalletAction\WithdrawLink;
use App\Contracts\Services\ParseFiles\ParseFileInterface;
use App\Exceptions\File\FileInvalidException;
use App\Exceptions\File\FileNotFoundException;
use App\Contracts\Services\Wallet\WalletCalculateManagerInterface;
use Illuminate\Support\Collection;

class CsvService implements ParseFileInterface
{
    private const VALID_FILE_EXTENSION = 'csv';

    /**
     * @var WalletCalculateManagerInterface[]
     */
    private $walletManager;

    private Collection $userHistoryCollection;

    public function __construct(
        iterable $actionWallets
    ) {
        $this->userHistoryCollection = collect();
        /** @var WalletCalculateManagerInterface $actionWallet */
        foreach ($actionWallets as $actionWallet) {
            $this->walletManager[$actionWallet->getType()] = $actionWallet;
        }
    }

    /**
     * @param string $fileName
     *
     * @throws FileInvalidException
     *
     * @throws FileNotFoundException
     */
    public function parseFile(string $fileName): void
    {
        $filePath = $this->getFilePath($fileName);
        $this->isFileValid($filePath, $fileName);

        $file = fopen($filePath, 'r+');

        try {
            while (($walletOperation = fgetcsv($file, 0, ',')) !== false) {
                if (empty($walletOperation[0])) {
                    continue;
                }

                $walletOperation = (new WalletOperationDataTransformer())->transformFromArray($walletOperation);
                $typeOfAction = (new WithdrawLink($walletOperation))->detectTypeOfAction();
                $walletAction = $this->walletManager[$typeOfAction] ?? [];

                if (empty($walletAction)) {
                    throw  new WalletActionException('This type of action was not found in the system');
                }

                list($percent, $userHistoryCollection) = $walletAction->calculateCommissionFee(
                    $walletOperation,
                    $this->userHistoryCollection
                );

                $this->userHistoryCollection = $userHistoryCollection;
                echo $percent . PHP_EOL;
            }
        } catch (\Throwable $e) {
            dd($e->getFile(), $e->getMessage(), $e->getLine());
        }


        fclose($file);
    }

    /**
     * @param string $filePath
     * @param string $fileName
     *
     * @throws FileInvalidException
     * @throws FileNotFoundException
     */
    private function isFileValid(string $filePath, string $fileName): void
    {
        $this->isPathValid($filePath);
        $this->isExtensionValid($fileName);
    }

    private function isPathValid(string $filePath): string
    {
        if (!file_exists($filePath)) {
            throw new FileNotFoundException('File not found', 404);
        }

        return $filePath;
    }

    private function isExtensionValid(string $fileName): void
    {
        $parsedFileName = explode('.', $fileName);

        if (empty($parsedFileName)) {
            throw new FileInvalidException('File is not valid', 400);
        }

        $fileExtension = last($parsedFileName);

        if (strcasecmp($fileExtension, self::VALID_FILE_EXTENSION)) {
            throw new FileInvalidException('Invalid File extension ', 400);
        }
    }

    public function getFilePath(string $fileName): string
    {
        return sprintf('%s/%s', storage_path('import'), $fileName);
    }
}
