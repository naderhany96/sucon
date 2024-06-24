<?php

namespace App\Http\Controllers\Api\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Auth;

class AuthController extends ApiController
{

    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|min:4|max:255'
        ]);

        $requestData = $request->only([
            'email',
            'password'
        ]);

        if (Auth::guard('admin')->attempt($requestData)){

            $authUser = Auth::guard('admin')->user();

            /** @var \App\Models\User $authUser **/
            $authUser->tokens()->delete();
            
            // logout user if not activated
            if ($authUser->isActive == 0) {
                $authUser->tokens()->delete();
                Auth::logout();
                return response()->json([
                    'errors' => ['error' => ['Not active.']],
                    'message'=> 'Account not active'
                ], 403);
            }

            return response()->json([
                'message' => 'Login Successfully',
                'data' => $this->getUserData($authUser)
            ]);

        }
        else{
            return response()->json([
                'errors' => ['error' => ['Unauthenticated.']],
                'message'=> 'The provided credentials are incorrect.'
            ], 422);
        }
    }

    public function logout(Request $request)
    {
        if (auth()->check()) {
            /** @var \App\Models\User $user **/
            $user = auth()->user();
            $user->tokens()->delete();
            Auth::logout();
        }

        return response()->json([
            'message' => 'Logout Successfully'
        ]);
    }

    public function refresh(Request $request)
    {
        /** @var \App\Models\User $user **/
        $user = Auth::user();
        $user->tokens()->delete();
        return $this->getUserData($user);
    }

    public function getUserData($authUser)
    {
        $data['id'] = $authUser->id;
        $data['name'] = $authUser->name;
        $data['email'] = $authUser->email;
        $data['mobile_phone'] = $authUser->mobile_phone;
        $data['isActive'] = $authUser->isActive;
        $data['isSuperAdmin'] = $authUser->isSuperAdmin;
        $data['token'] = 'Bearer ' . $authUser->createToken($authUser->name)->plainTextToken;
        $data['permissions'] = $authUser->getPermissionNames();

        return $data;
    }
}
