<?php

namespace App\Http\Controllers\Api\Admin;

use App\Facades\AuthAdmin;
use App\Models\AppSetting;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class AppSettingsController extends ApiController
{

    private String $pname = "app";

    public function all()
    {
        return AppSetting::first();
    }

    public function index()
    {
        AuthAdmin::can_abort("access_$this->pname");

        return AppSetting::findOrFail(1);
    }

    public function update(Request $request)
    {
        AuthAdmin::can_abort("edit_$this->pname");

        $request->validate(['commission' => 'required']);

        $appSetting = AppSetting::findOrFail(1);

        $appSetting->update($request->only('commission'));
        
        return response()->json('Updated Succesfully');
    }
}
