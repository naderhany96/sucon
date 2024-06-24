<?php

namespace App\Providers;

use App\Services\Auth\AuthUser;
use Illuminate\Support\ServiceProvider;

class AuthUserServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind('AuthUser', function(){
            $authUser = auth()->user();
            return new AuthUser($authUser);
        });
    }
}
