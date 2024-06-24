<?php

namespace App\Providers;

use App\Services\Auth\AuthAdmin;
use Illuminate\Support\ServiceProvider;

class AuthAdminServiceProvider extends ServiceProvider
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
        $this->app->bind('AuthAdmin', function(){
            $authUser = auth()->user();
            return new AuthAdmin($authUser);
        });
    }
}
