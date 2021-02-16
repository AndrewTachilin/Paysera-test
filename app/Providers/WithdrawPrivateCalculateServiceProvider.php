<?php

declare(strict_types=1);

namespace App\Providers;

use App\Contracts\Strategies\PrivateStrategyInterface;
use App\Strategies\WithdrawRules\PrivateStrategy;
use Illuminate\Support\ServiceProvider;

class WithdrawPrivateCalculateServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->app->tag([PrivateStrategyInterface::class], ['client-type']);

        $this->app->singleton(PrivateStrategyInterface::class, PrivateStrategy::class);
    }
}
