<?php

namespace App\Providers;

use App\Repositories\ApplicationRepository;
use App\Repositories\Interfaces\ApplicationRepositoryInterface;
use Illuminate\Support\ServiceProvider;
use App\Repositories\Interfaces\LeadRepositoryInterface;
use App\Repositories\LeadRepository;

class AppServiceProvider extends ServiceProvider
{
    
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(LeadRepositoryInterface::class, LeadRepository::class);
        $this->app->bind(ApplicationRepositoryInterface::class, ApplicationRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
