<?php

namespace App\Providers;

use App\Models\comisions;
use App\Observers\ComisionsObserver;
use Illuminate\Pagination\Paginator;
use \Illuminate\Support\Facades\URL;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
        // comisions::observe(ComisionsObserver::class); aquí es para laravel más viejitos, en el 10 va en EventoServiceProvider
        Paginator::useBootstrapFive();

    }

    
}
