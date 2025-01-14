<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRateLimiting();

        $this->routes(function () {

            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/web.php'));
            
            Route::prefix('api-web')
                ->middleware('api')
                ->namespace($this->namespace)
                ->group(base_path('routes/api_web.php'));

            Route::prefix('admin')
                ->middleware('api')
                ->namespace($this->namespace)
                ->group(base_path('routes/admin_web.php'));

            Route::prefix('api-admin')
                ->middleware('api')
                ->namespace($this->namespace)
                ->group(base_path('routes/api_admin.php'));

            Route::prefix('api-mobile')
                ->middleware('api')
                ->namespace($this->namespace)
                ->group(base_path('routes/api_mobile.php'));
        });
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
    }
}
