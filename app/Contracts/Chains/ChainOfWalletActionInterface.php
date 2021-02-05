<?php

declare(strict_types=1);

namespace App\Contracts\Chains;

interface ChainOfWalletActionInterface
{
    public function detectTypeOfAction(): string;
}
