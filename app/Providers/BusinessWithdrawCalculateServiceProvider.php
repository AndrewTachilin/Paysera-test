<?php

declare(strict_types=1);

namespace App\Providers;

use App\Contracts\Services\WithdrawRules\ClientTypeInterface;
use App\DataTransformer\WalletOperationDataTransformer;
use App\Services\Wallet\MathOperations;
use App\Strategies\WithdrawRules\BusinessStrategy;
use Illuminate\Container\Container;
use Illuminate\Support\ServiceProvider;

class BusinessWithdrawCalculateServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->app->tag([BusinessStrategy::class], ['client-type']);

        $this->app->singleton(ClientTypeInterface::class, function (Container $app) {
            return new BusinessStrategy(
                $app->get(MathOperations::class),
                new WalletOperationDataTransformer($app->get(MathOperations::class))
            );
        });
    }
}
