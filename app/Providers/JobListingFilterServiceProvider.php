<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\JobListingFilterService;

class JobListingFilterServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     * This method binds JobListingFilterService to the service container.
     */
    public function register(): void
    {
        $this->app->singleton(JobListingFilterService::class, function ($app) {
            return new JobListingFilterService();
        });
    }

    /**
     * Bootstrap services.
     * This method runs when all services are registered.
     */
    public function boot(): void
    {
        //
    }
}
