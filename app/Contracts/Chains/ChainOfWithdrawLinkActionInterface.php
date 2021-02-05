<?php

declare(strict_types=1);

namespace App\Contracts\Chains;

use Illuminate\Support\Collection;

interface ChainOfWithdrawLinkActionInterface
{
    public function detectClientType(Collection $userHistories): array;
}
