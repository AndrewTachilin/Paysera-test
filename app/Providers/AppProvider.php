<?php

declare(strict_types=1);

namespace App\Providers;

use App\Services\Wallet\WalletDepositCalculateService;
use App\Strategies\WalletAction\DepositStrategy;
use App\Strategies\WalletAction\WithdrawStrategy;
use App\Strategies\WithdrawRules\BusinessStrategy;
use App\Strategies\WithdrawRules\PrivateStrategy;
use Illuminate\Support\ServiceProvider;

class AppProvider extends ServiceProvider
{
    public function boot()
    {
        $this->app->tag([BusinessStrategy::class], ['client-type']);
        $this->app->tag([PrivateStrategy::class], ['client-type']);
        $this->app->tag([DepositStrategy::class], ['wallet-type-action']);
        $this->app->tag([WithdrawStrategy::class], ['wallet-type-action']);
        $this->app->tag([WalletDepositCalculateService::class], ['wallet-action']);
    }
}
