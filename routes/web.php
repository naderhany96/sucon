<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () { return view('welcome'); });

Route::post('login', [ 'as' => 'login', 'uses' => 'LoginController@do']);// don't remove this
