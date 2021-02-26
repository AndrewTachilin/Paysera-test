<?php

declare(strict_types=1);

namespace App\Contracts\Strategies;

interface FileStrategyInterface
{
    public function getType(): string;

    public function parseFile(string $fileName): array;
}
