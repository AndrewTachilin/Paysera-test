<?php

declare(strict_types=1);

namespace App\Contracts\Strategies;

use App\Contracts\Services\WithdrawRules\ClientTypeInterface;

interface PrivateStrategyInterface extends ClientTypeInterface
{
    public const CLIENT_TYPE = 'private';
}
