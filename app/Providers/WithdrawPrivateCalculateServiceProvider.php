<?php

declare(strict_types=1);

namespace App\Providers;

use App\Contracts\Strategies\PrivateStrategyInterface;
use App\Services\Wallet\MathOperations;
use App\Strategies\WithdrawRules\PrivateStrategy;
use GuzzleHttp\Client;
use Illuminate\Container\Container;
use Illuminate\Support\ServiceProvider;

class WithdrawPrivateCalculateServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->app->tag([PrivateStrategyInterface::class], ['client-type']);

        $this->app->singleton(PrivateStrategyInterface::class, function (Container $app) {
            return new PrivateStrategy(
                new MathOperations(),
                new Client(),
                $app->tagged('currency-exchange')
            );
        });
    }
}
