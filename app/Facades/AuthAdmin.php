<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class AuthAdmin extends Facade
{
    /**
     * @method static int id()
     * @method static \Illuminate\Foundation\Auth\User user()
     * @method static void|\Illuminate\Http\Exceptions\HttpResponseException can_abort(string $permissionName)
     * @method static bool can(string $permissionName)
     * 
     * @see \App\Services\Auth\AuthAdmin
     */

    protected static function getFacadeAccessor()
    {
        return 'AuthAdmin';
    }
}