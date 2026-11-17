<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route; //

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
        Route::macro('home', function () {
            return '/dashboard';
        });

        RateLimiter::for('login', fn (Request $r) => Limit::perMinute(5)->by($r->ip()));
        RateLimiter::for('otp', fn (Request $r) => Limit::perMinute(10)->by($r->ip()));
        RateLimiter::for('api-token', fn (Request $r) => Limit::perMinute(5)->by($r->ip()));
        RateLimiter::for('email-relay', fn (Request $r) => Limit::perMinute(3)->by($r->ip()));
    }
}
