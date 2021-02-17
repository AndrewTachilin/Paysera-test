<?php

declare(strict_types=1);

namespace App\Providers;

use App\Strategies\WithdrawRules\PrivateStrategy;
use Illuminate\Support\ServiceProvider;

class WithdrawPrivateCalculateServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->app->tag([PrivateStrategy::class], ['client-type']);
        $this->app->singleton(PrivateStrategy::class, PrivateStrategy::class);
    }
}
