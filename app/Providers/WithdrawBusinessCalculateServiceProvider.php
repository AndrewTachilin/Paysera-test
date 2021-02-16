<?php

declare(strict_types=1);

namespace App\Providers;

use App\Contracts\Strategies\BusinessStrategyInterface;
use App\Strategies\WithdrawRules\BusinessStrategy;
use Illuminate\Support\ServiceProvider;

class WithdrawBusinessCalculateServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->app->tag([BusinessStrategyInterface::class], ['client-type']);
        $this->app->singleton(BusinessStrategyInterface::class, BusinessStrategy::class);
    }
}
