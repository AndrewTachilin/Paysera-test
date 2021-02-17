<?php

declare(strict_types=1);

namespace App\Providers;

use App\Strategies\WalletAction\WithdrawStrategy;
use Illuminate\Support\ServiceProvider;

class WithdrawStrategyProvider extends ServiceProvider
{
    public function boot()
    {
        $this->app->tag([WithdrawStrategy::class], ['wallet-type-action']);
        $this->app->singleton(WithdrawStrategy::class, WithdrawStrategy::class);
    }
}
