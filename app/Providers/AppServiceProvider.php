<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Route;

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
        Route::resourceVerbs([
            'create' => 'creer',
            'edit'   => 'editer',
        ]);
    }
}
