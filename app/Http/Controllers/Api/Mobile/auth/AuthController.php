<?php

namespace App\Http\Controllers\Api\Mobile\auth;

use App\Http\Requests\{
    LoginRequest,
    GenerateOTPRequest,
    NewPasswordRequest,
    ValidateOTPRequest,
    RegistrationRequest,
    ForgotPasswordRequest
};
use App\Facades\AuthUser;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends ApiController
{
    public function login(LoginRequest $request)
    {
        $user = AuthUser::login($request->validated());

        if ($user) {
            if ($request->filled('time_zone_id')) {
                auth()->user()->update(['time_zone_id' => $request->time_zone_id]);
            }
            return $this->successResponse('Login Successfully', Response::HTTP_OK, $user);
        }

        return $this->errorResponse('The provided credentials are incorrect.', Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function verify(Request $request)
    {
        $request->validate([
            'email' => 'required|exists:users'
        ]);

        $user = AuthUser::verify($request->all());


        if ($user) return $this->successResponse('Login Successfully', Response::HTTP_OK, $user);
    }

    public function register(RegistrationRequest $request)
    {
        $user = AuthUser::register($request->validated());

        if ($user) {
            if ($request->filled('time_zone_id')) {
                User::where('email', $user->email)->update(['time_zone_id' => $request->time_zone_id]);
            }
            return $this->successResponse('Register Successfully');
        }

        return $this->errorResponse('Registration fail', Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    public function generateOTP(GenerateOTPRequest $request)
    {
        $otp = AuthUser::sendOTP($request->validated(), 'email');

        if (isset($otp->status) && $otp->status === true)
            return $this->successResponse('OTP sent successfully');

        return $this->errorResponse('OTP not sent', Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    public function validateOTP(ValidateOTPRequest $request)
    {
        $otp = AuthUser::validateOTP($request->validated());

        if (isset($otp->status) && $otp->status === true) {

            AuthUser::verifyeUserAccount($request->validated());

            $user = AuthUser::getUser($request->email);

            if ($user) {
                return $this->successResponse('OTP is valid', Response::HTTP_OK, $user);
            } else {
                // could not find a user by email number
                return $this->errorResponse(
                    'The provided credentials are incorrect',
                    Response::HTTP_BAD_REQUEST
                );
            }
        }

        return $this->errorResponse('OTP is not valid', Response::HTTP_NOT_ACCEPTABLE);
    }

    public function forgotPassword(ForgotPasswordRequest $request)
    {
        $otp = AuthUser::sendOTP($request->validated(), 'email');

        if (isset($otp->status) && $otp->status === true)
            return $this->successResponse('OTP sent successfully to your email');

        return $this->errorResponse('OTP not sent', Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function newPassword(NewPasswordRequest $request)
    {
        $user = AuthUser::changePassword($request->validated());

        if ($user) return $this->successResponse('New password has been set');

        return $this->errorResponse('Server error', Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    public function logout(Request $request)
    {
        AuthUser::logout($request);

        return $this->successResponse('Logout Successfully');
    }

    public function verificationResend(Request $request)
    {
        $request->user()->sendEmailVerificationNotification();

        return $this->successResponse('Verification link sent');
    }

    public function deleteAccount()
    {
        AuthUser::deleteAccount();

        return $this->successResponse('Deleted Succesfully');
    }
}
