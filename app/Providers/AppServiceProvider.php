<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;



class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // inline asset directive
        Blade::directive('inline', function($file) {
            $file = str_replace(['"', "'"], '', $file);
            return file_get_contents(public_path($file));
        });

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
	//error_reporting(E_ALL ^ E_NOTICE);
        //error_reporting(E_PARSE);    
        \Illuminate\Http\Resources\Json\JsonResource::withoutWrapping();
    }
}
