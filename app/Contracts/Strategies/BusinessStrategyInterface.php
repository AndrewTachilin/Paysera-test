<?php

declare(strict_types=1);

namespace App\Contracts\Strategies;

use App\Contracts\Services\WithdrawRules\ClientTypeInterface;

interface BusinessStrategyInterface extends ClientTypeInterface
{
    public const CLIENT_TYPE = 'business';
}
