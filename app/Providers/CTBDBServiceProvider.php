<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Provide interface to CTB database
 */

class CTBDBServiceProvider extends ServiceProvider
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
        //
    }

    public static function table(string $t)
    {
        return \DB::connection('ctb_data')->table($t);
    }
}
