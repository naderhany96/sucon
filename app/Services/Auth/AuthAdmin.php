<?php

namespace App\Services\Auth;

class AuthAdmin 
{
    private $user;

    public function __construct($user)
    {
        $this->user = $user;
    }
    
    /**
     * Get the value of user id
     */ 
    public function id() :int
    {
        return $this->user->id;
    }
    
    /**
     * Get the value of user
     */ 
    public function user() :\Illuminate\Foundation\Auth\User
    {
        return $this->user;
    }

    public function can_abort($permissionName) :?\Symfony\Component\HttpFoundation\Response
    {
        $msg = ['message'=> 'Permission denied'];

        if (!$this->user->can($permissionName)) {
            abort(response()->json($msg, 403));
        }
        
        return null;
    }

    public function can($permissionName) :bool
    {
        return $this->user->can($permissionName);
    }
}