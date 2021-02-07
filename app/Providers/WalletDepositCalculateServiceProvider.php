<?php

declare(strict_types=1);

namespace App\Providers;

use App\Contracts\Services\Wallet\WalletDepositCalculateManagerInterface;
use App\Services\Wallet\MathOperations;
use App\Services\Wallet\WalletDepositCalculateService;
use Illuminate\Container\Container;
use Illuminate\Support\ServiceProvider;

class WalletDepositCalculateServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->app->tag([WalletDepositCalculateManagerInterface::class], ['wallet-action']);

        $this->app->singleton(WalletDepositCalculateManagerInterface::class, function (Container $app) {
            return new WalletDepositCalculateService(new MathOperations());
        });
    }
}
