<?php

namespace App\Providers;

use App\Repositories\RouterOSInterface;
use App\Repositories\RouterOSRepository;
use Illuminate\Support\ServiceProvider;

class RouterOsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            RouterOSInterface::class,
            RouterOSRepository::class
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
