<?php

declare(strict_types=1);

namespace App\Contracts\Services\Data;

interface CalculateServiceInterface
{
    public function calculate(array $lines): array;
}
