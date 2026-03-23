<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Gate;

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
        setlocale(LC_ALL, 'es_ES');
        if (config('app.env') === 'production') {
            \URL::forceScheme('https');
        }
        Gate::before(function ($user, $ability) {
            return $user->email == 'estadistica@puebla.gob.mx' ?? null;
        });
        Schema::defaultStringLength(191);
    }
}
