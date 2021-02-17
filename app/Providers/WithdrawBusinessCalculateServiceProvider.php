<?php

declare(strict_types=1);

namespace App\Providers;

use App\Strategies\WithdrawRules\BusinessStrategy;
use Illuminate\Support\ServiceProvider;

class WithdrawBusinessCalculateServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->app->tag([BusinessStrategy::class], ['client-type']);
        $this->app->singleton(BusinessStrategy::class, BusinessStrategy::class);
    }
}
