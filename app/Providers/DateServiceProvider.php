<?php
namespace App\Providers;
use Illuminate\Support\ServiceProvider;
use App\Services\DateService;
class DateServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(DateService::class, function ($app) {
            return new DateService();
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
