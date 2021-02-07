<?php

declare(strict_types=1);

namespace App\Providers;

use App\Chains\ChainOfCurrencyExchange\EuroStrategy;
use App\Chains\ChainOfCurrencyExchange\JpyStrategy;
use App\Chains\ChainOfCurrencyExchange\UsdStrategy;
use App\Contracts\Strategies\EuroExchangeInterface;
use App\Contracts\Strategies\JpyExchangeInterface;
use App\Contracts\Strategies\UsdExchangeInterface;
use App\Services\Wallet\MathOperations;
use Illuminate\Container\Container;
use Illuminate\Support\ServiceProvider;

class UsdStrategyProvider extends ServiceProvider
{
    public function boot()
    {
        $this->app->tag([UsdExchangeInterface::class], ['currency-exchange']);
        $this->app->tag([JpyExchangeInterface::class], ['currency-exchange']);
        $this->app->tag([EuroExchangeInterface::class], ['currency-exchange']);

        $this->app->singleton(UsdExchangeInterface::class, function (Container $app) {
            return new UsdStrategy(new MathOperations());
        });

        $this->app->singleton(JpyExchangeInterface::class, function (Container $app) {
            return new JpyStrategy(new MathOperations());
        });

        $this->app->singleton(EuroExchangeInterface::class, function (Container $app) {
            return new EuroStrategy(new MathOperations());
        });
    }
}
