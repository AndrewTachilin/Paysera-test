<?php

declare(strict_types=1);

namespace App\Providers;

use App\Contracts\Strategies\DepositStrategyInterface;
use App\Strategies\WalletAction\DepositStrategy;
use Illuminate\Support\ServiceProvider;

class DepositStrategyProvider extends ServiceProvider
{
    public function boot()
    {
        $this->app->tag([DepositStrategyInterface::class], ['wallet-type-action']);

        $this->app->singleton(DepositStrategyInterface::class, DepositStrategy::class);
    }
}
