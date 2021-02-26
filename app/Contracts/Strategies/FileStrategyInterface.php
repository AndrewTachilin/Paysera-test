<?php

declare(strict_types=1);

namespace App\Contracts\Strategies;

interface FileStrategyInterface
{
    public function getType(): string;

    /**
     * @param string $fileName
     *
     * @return mixed
     */
    public function parseFile(string $fileName);
}
