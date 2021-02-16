<?php

declare(strict_types=1);

namespace App\Contracts\Strategies;

interface WithdrawStrategyInterface extends ActionStrategyInterface
{
    public const TYPE = 'withdraw';
}
