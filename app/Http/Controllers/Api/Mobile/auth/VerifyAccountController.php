<?php

namespace App\Http\Controllers\Api\Mobile\auth;

use App\Models\UserEmailVerify;
use App\Http\Controllers\Controller;

class VerifyAccountController extends Controller
{

    public function verify($token)
    {
        $verifyUser = UserEmailVerify::where('token', $token)->first();

        $message = 'Sorry your email cannot be identified.';

        if ($verifyUser) {
            $user = $verifyUser->verifiable;
            if (empty($user->email_verified_at)) {
                $user->email_verified_at = now();
                $user->save();
                $message = "Your e-mail is verified. You can now login.";
            } else {
                $message = "Your e-mail is already verified. You can now login.";
            }
        }

        return view('emails.email-verified', ["message" => $message]);
    }
}
