<?php

declare(strict_types=1);

namespace App\Providers;

use App\Contracts\Services\Wallet\WalletWithdrawCalculateManagerInterface;
use App\Services\Wallet\WalletWithdrawCalculateService;
use Illuminate\Container\Container;
use Illuminate\Support\ServiceProvider;

class WalletWithdrawCalculateServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->app->tag([WalletWithdrawCalculateManagerInterface::class], ['wallet-action']);
        $this->app->singleton(WalletWithdrawCalculateManagerInterface::class, function (Container $app) {
            return new WalletWithdrawCalculateService(
                $app->tagged('client-type')
            );
        });
    }
}
