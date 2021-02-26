<?php

declare(strict_types=1);

namespace App\Services\ParseFiles;

use App\Contracts\Strategies\FileStrategyInterface;
use App\Contracts\Services\ParseFiles\ParseFileInterface;
use App\Exceptions\File\FileInvalidException;
use Dotenv\Exception\InvalidFileException;

class ParseService implements ParseFileInterface
{
    /** @var FileStrategyInterface[] $fileParsers */
    private iterable $fileParsers;

    public function __construct(
        iterable $availableExtensions
    ) {
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
