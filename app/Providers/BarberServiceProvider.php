<?php

namespace App\Providers;

use App\Observers\ServiceObserver;
use App\Service;
use Illuminate\Support\ServiceProvider;

class BarberServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Service::observe(ServiceObserver::class);
    }
}
