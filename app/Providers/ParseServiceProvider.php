<?php

declare(strict_types=1);

namespace App\Providers;

use App\Services\ParseFiles\ParseService;
use Illuminate\Container\Container;
use Illuminate\Support\ServiceProvider;

class ParseServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->app->singleton(ParseService::class, function (Container $app) {
            return new ParseService(
                $app->tagged('file-parsers')
            );
        });
    }
}
