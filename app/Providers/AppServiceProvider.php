<?php

namespace App\Providers;

use App\Interfaces\AcquisitionRepositoryInterface;
use Illuminate\Support\ServiceProvider;
use App\Repositories\AcquisitionRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(AcquisitionRepositoryInterface::class, AcquisitionRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
