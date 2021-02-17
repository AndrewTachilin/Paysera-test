<?php

declare(strict_types=1);

namespace App\Providers;

use App\Services\Wallet\WalletDepositCalculateService;
use Illuminate\Support\ServiceProvider;

class WalletDepositCalculateServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->app->tag([WalletDepositCalculateService::class], ['wallet-action']);
        $this->app->singleton(WalletDepositCalculateService::class, WalletDepositCalculateService::class);
    }
}
