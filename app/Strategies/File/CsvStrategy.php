<?php

declare(strict_types=1);

namespace App\Strategies\File;

use App\Contracts\Strategies\FileStrategyInterface;
use App\Exceptions\File\FileNotFoundException;

class CsvStrategy implements FileStrategyInterface
{
    private string $extension;

    public function __construct()
    {
        $this->extension = config('app.file_extensions.csv');
    }

    public function getType(): string
    {
        return $this->extension;
    }

    /**
     * @param string $fileName
     * @return array
     *
     * @throws FileNotFoundException
     */
    public function parseFile(string $fileName): array
    {
        $filePath = $this->getFilePath($fileName);
        $this->isPathValid($filePath);

        $file = fopen($filePath, 'rb+');
        $rows = [];
        while (($walletOperation = fgetcsv($file)) !== false) {
            if (empty($walletOperation[0])) {
                continue;
            }

            $rows[] = $walletOperation;
        }
        fclose($file);

        return $rows;
    }

    private function getFilePath(string $fileName): string
    {
        return sprintf('%s/%s', storage_path('import'), $fileName);
    }


    private function isPathValid(string $filePath): string
    {
        if (!file_exists($filePath)) {
            throw new FileNotFoundException('File not found');
        }

        return $filePath;
    }
}
