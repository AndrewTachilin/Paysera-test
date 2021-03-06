<?php

declare(strict_types=1);

namespace App\Providers;

use App\Contracts\Services\Data\DataServiceInterface;
use App\DataTransformer\CalculationDataTransformer;
use App\DataTransformer\WalletOperationDataTransformer;
use App\Services\Data\DataService;
use Illuminate\Container\Container;
use Illuminate\Support\ServiceProvider;

class DataServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->app->singleton(DataServiceInterface::class, function (Container $app) {
            return new DataService(
                $app->get(WalletOperationDataTransformer::class),
                $app->get(CalculationDataTransformer::class),
                $app->tagged('wallet-action'),
                $app->tagged('wallet-type-action')
            );
        });
    }
}
