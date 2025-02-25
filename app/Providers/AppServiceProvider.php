<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Middleware\ThrottleRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
        // ...
        Route::middleware('throttle:10,1') // 10 requests per minute
             ->group(function () {
                 Route::post('/forgot-password', function (Request $request) {
                     // ...
                 })->middleware('guest')->name('password.email');
             });
    }
}
