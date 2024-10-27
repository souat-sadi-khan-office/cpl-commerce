<?php

namespace App\Providers;

use App\Models\Currency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\ServiceProvider;
use Illuminate\Cache\RateLimiting\Limit;
use Stevebauman\Location\Facades\Location;
use Illuminate\Support\Facades\RateLimiter;

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
        Schema::defaultStringLength(191);
        if (!file_exists(public_path('storage'))) {
            try {
                // Call artisan command to create symbolic link
                Artisan::call('storage:link');
            } catch (\Exception $e) {
                // Handle any exceptions if the command fails
                Log::error('Error occurred while linking storage: ' . $e->getMessage());
            }
        }
        $this->configureRateLimiting();
    }


    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    public function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
    }
    
}
