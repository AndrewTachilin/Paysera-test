<?php

declare(strict_types=1);

namespace App\Contracts\Strategies;

interface DepositStrategyInterface extends ActionStrategyInterface
{
    public const TYPE = 'deposit';
}
