<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Services\CTB\Util;
use App\Services\CTB\Districts;
use App\Services\CTB\HouseCandidates;
use App\Services\CTB\Propositions;

class CTBServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('App\Services\CTB\Util', function ($app) {
            return new Util;
        });
        $this->app->singleton('App\Services\CTB\Districts', function ($app) {
            return new Districts;
        });
        $this->app->singleton('App\Services\CTB\HouseCandidates', function ($app) {
            return new HouseCandidates;
        });
        $this->app->singleton('App\Services\CTB\Propositions', function ($app) {
            return new Propositions;
        });
    }

}
