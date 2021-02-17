<?php

declare(strict_types=1);

namespace App\Providers;

use App\Strategies\WalletAction\DepositStrategy;
use Illuminate\Support\ServiceProvider;

class DepositStrategyProvider extends ServiceProvider
{
    public function boot()
    {
        $this->app->tag([DepositStrategy::class], ['wallet-type-action']);
        $this->app->singleton(DepositStrategy::class, DepositStrategy::class);
    }
}
