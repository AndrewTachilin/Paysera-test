<?php

declare(strict_types=1);

namespace App\Providers;

use App\Contracts\Services\Data\DataServiceInterface;
use App\DataTransformer\WalletOperationDataTransformer;
use App\Requests\CurrencyExchange\CurrencyExchangeApiRequest;
use App\Services\Data\CalculateCommissionService;
use App\Services\ParseFiles\ParseService;
use Illuminate\Container\Container;
use Illuminate\Support\ServiceProvider;

class ParseServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->app->singleton(ParseService::class, function (Container $app) {
            return new ParseService(
                $app->get(CurrencyExchangeApiRequest::class),
                $app->get(WalletOperationDataTransformer::class),
                $app->get(DataServiceInterface::class),
                $app->get(CalculateCommissionService::class),
                $app->tagged('file-parsers')
            );
        });
    }
}
