<?php

declare(strict_types=1);

namespace App\Providers;

use App\Contracts\Services\ParseFiles\ParseFileInterface;
use App\DataTransformer\WalletOperationDataTransformer;
use App\Services\ParseFiles\CsvService;
use App\Services\Wallet\MathOperations;
use Illuminate\Container\Container;
use Illuminate\Support\ServiceProvider;

class CsvServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->app->singleton(ParseFileInterface::class, function (Container $app) {
            return new CsvService(
                new WalletOperationDataTransformer($app->get(MathOperations::class)),
                $app->tagged('wallet-action'),
                $app->tagged('wallet-type-action')
            );
        });
    }
}
