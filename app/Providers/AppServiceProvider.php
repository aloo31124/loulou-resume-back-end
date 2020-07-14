<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\App;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //https://stackoverflow.com/questions/34378122/load-blade-assets-with-https-in-laravel
        if(App::environment() === 'production' || config('app.env') === 'production' ) {
            \URL::forceScheme('https');
        }
    }
}
