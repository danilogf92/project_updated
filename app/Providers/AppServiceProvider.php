<?php

namespace App\Providers;

use App\Services\Dashboard\DashboardDataService;
use App\Services\Dashboard\DashboardService;
use App\Services\Projects\ProjectChartService;
use App\Services\Projects\ProjectFilterService;
use App\Services\Projects\ProjectMetricService;
use App\Services\Support\CapexCalculator;
use App\Services\Support\ColorService;
use App\Services\Support\CurrencyService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Servicios de Support
        $this->app->singleton(CurrencyService::class);
        $this->app->singleton(CapexCalculator::class);
        $this->app->singleton(ColorService::class);

        // Servicios de Projects
        $this->app->singleton(ProjectFilterService::class);

        $this->app->singleton(ProjectMetricService::class, function ($app) {
            return new ProjectMetricService(
                $app->make(CurrencyService::class),
                $app->make(CapexCalculator::class),
                $app->make(ProjectFilterService::class)
            );
        });

        $this->app->singleton(ProjectChartService::class, function ($app) {
            return new ProjectChartService(
                $app->make(CurrencyService::class),
                $app->make(ColorService::class),
                $app->make(ProjectFilterService::class)
            );
        });

        // Servicios de Dashboard
        $this->app->singleton(DashboardService::class, function ($app) {
            return new DashboardService(
                $app->make(ProjectFilterService::class),
                $app->make(ProjectMetricService::class),
                $app->make(ProjectChartService::class)
            );
        });

        $this->app->singleton(DashboardDataService::class, function ($app) {
            return new DashboardDataService(
                $app->make(ProjectFilterService::class),
                $app->make(ProjectMetricService::class),
                $app->make(ProjectChartService::class)
            );
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
