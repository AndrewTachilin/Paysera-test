<?php

declare(strict_types=1);

namespace App\Contracts\Strategies;

interface ActionStrategyInterface
{
    public function getType(): string;

    public function detectTypeOfAction(): string;
}
