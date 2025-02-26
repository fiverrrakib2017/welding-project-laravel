<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\InvoiceService;
class InvoiceServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(InvoiceService::class, function ($app) {
            return new InvoiceService();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
