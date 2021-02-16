<?php

declare(strict_types=1);

namespace App\Providers;

use App\Services\Wallet\MathOperations;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public $singletons = [
        MathOperations::class => MathOperations::class,
    ];

    public function boot()
    {
        $this->app->singleton(MathOperations::class, function () {
            return new MathOperations();
        });
    }
}
