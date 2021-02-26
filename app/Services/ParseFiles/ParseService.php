<?php

declare(strict_types=1);

namespace App\Services\ParseFiles;

use App\Contracts\Services\Data\DataServiceInterface;
use App\Contracts\Strategies\FileStrategyInterface;
use App\DataTransformer\WalletOperationDataTransformer;
use App\Exceptions\ParseFile\ParseFileException;
use App\Contracts\Services\ParseFiles\ParseFileInterface;
use App\Exceptions\File\FileInvalidException;
use App\Requests\CurrencyExchange\CurrencyExchangeApiRequest;
use App\Services\Data\CalculateCommissionService;
use Dotenv\Exception\InvalidFileException;
use Illuminate\Support\Collection;

class ParseService implements ParseFileInterface
{
    private Collection $userHistoryCollection;

    private WalletOperationDataTransformer $dataTransformer;

    private CurrencyExchangeApiRequest $exchangeApiRequest;

    private DataServiceInterface $dataService;

    private CalculateCommissionService $calculationService;

    /** @var FileStrategyInterface[] $fileParsers */
    private iterable $fileParsers;

    public function __construct(
        CurrencyExchangeApiRequest $exchangeApiRequest,
        WalletOperationDataTransformer $dataTransformer,
        DataServiceInterface $dataService,
        CalculateCommissionService $calculationService,
        iterable $availableExtensions
    ) {
        $this->exchangeApiRequest = $exchangeApiRequest;
        $this->dataService = $dataService;
        $this->calculationService = $calculationService;

        /** @var FileStrategyInterface $fileParser */
        foreach ($availableExtensions as $availableExtension) {
            $this->fileParsers[$availableExtension->getType()] = $availableExtension;
        }
    }


    public function parseFile(string $fileName)
    {
        $extension = $this->isExtensionValid($fileName);
        $file = $this->fileParsers[$extension] ?? null;

        if (null === $file) {
            throw new InvalidFileException('invalid file');
        }

        return $file->parseFile($fileName);
    }

    private function isExtensionValid(string $fileName): string
    {
        $parsedFileName = explode('.', $fileName);

        if (empty($parsedFileName)) {
            throw new FileInvalidException('File is not valid');
        }

        return last($parsedFileName);
    }
}
