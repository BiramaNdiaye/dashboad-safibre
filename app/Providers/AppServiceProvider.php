<?php

namespace App\Providers;
use App\Models\Taches;
use App\Observers\TacheObserver;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(125);
        if (env('APP_ENV') === 'production') {
            URL::forceScheme('https');
        }
          Taches::observe(TacheObserver::class);
          
    }
}
