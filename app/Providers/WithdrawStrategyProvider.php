<?php

declare(strict_types=1);

namespace App\Providers;

use App\Contracts\Strategies\WithdrawStrategyInterface;
use App\Models\Actions\WalletOperation;
use App\Strategies\WalletAction\WithdrawStrategy;
use Illuminate\Support\ServiceProvider;

class WithdrawStrategyProvider extends ServiceProvider
{
    public function boot()
    {
        $this->app->tag([WithdrawStrategyInterface::class], ['wallet-type-action']);

        $this->app->singleton(WithdrawStrategyInterface::class, function () {
            return new WithdrawStrategy(new WalletOperation());
        });
    }
}
