<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Class ObserverServiceProvider.
 */
class ObserverServiceProvider extends ServiceProvider
{
    /**
     * Register bindings in the container.
     */
    public function boot()
    {
        #User::observe(UserObserver::class);
    }

    /**
     * Register the service provider.
     */
    public function register()
    {
        //
    }
}
