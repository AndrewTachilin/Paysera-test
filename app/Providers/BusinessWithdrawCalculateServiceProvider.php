<?php

declare(strict_types=1);

namespace App\Providers;

use App\Contracts\Services\WithdrawRules\ClientTypeInterface;
use App\Strategies\WithdrawRules\BusinessStrategy;
use Illuminate\Support\ServiceProvider;

class BusinessWithdrawCalculateServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->app->tag([BusinessStrategy::class], ['client-type']);

        $this->app->singleton(ClientTypeInterface::class, BusinessStrategy::class);
    }
}
