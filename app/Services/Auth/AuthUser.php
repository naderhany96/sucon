<?php

namespace App\Services\Auth;

use App\Models\{
    User,
    Media,
    PatientProfile
};
use Ichtrojan\Otp\Otp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Auth, Mail};

class AuthUser
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

    /**
     * Get the value of user_type
     */
    public function type() :string
    {
        return $this->user->user_type;
    }

    public function getUser($phone)
    {
        $user = User::where('phone', $phone)->first();
        return $user != null ? $this->getUserData(User::where('phone', $phone)->first()) : null;
    }

    public function login($credentials)
    {
        $data['password'] = $credentials['password'];

        // if(is_numeric($credentials['email'])){
        //     $data['phone'] = $credentials['email'];
        // } else {
            $data['email'] = $credentials['email'];
        // }

        if (Auth::guard('user')->attempt($data)) {

            $user = Auth::user();

            /** @var \App\Models\User $user **/
            $user->tokens()->delete();

            if (empty($user->email_verified_at)) {
                abort(response()->json([
                    'status' => "fail",
                    'message' => "Please verify your account before login",
                ], 401));
            }

            return $this->getUserData($user);
        }

        return null;
    }

    public function verify($credentials)
    {
        $data['email'] = $credentials['email'];

        $user = User::where('email', $credentials['email'])->first();

        $user->update(['email_verified_at' => now()]);

        return $this->getUserData($user);
    }

    public function register($requestData, $type = 'patient')
    {
        $requestData['password'] = bcrypt($requestData['password']);

        $user = User::create($requestData);

        if ($type === 'patient') {

            $patientProfile = new PatientProfile;

            $patientProfile->user_id = $user->id;

            $user->patientProfile()->save($patientProfile);

            $this->createUserAvatar($user);
        }

        return $user;
    }

    public function sendOTP($requestData, $type)
    {
        $otp = $type === 'email'
        ? (new Otp())->generate($requestData['email'], 6, 30)
        : (new Otp())->generate($requestData['phone'], 6, 30);

        if (isset($otp->status) && $otp->status === true) {

            $this->sendMail(
                'emails.emailOTP', ['otp' => $otp->token],
                $requestData['email'], 'Email OTP'
            );

            return $otp;
        }

        return null;
    }

    public function validateOTP($requestData)
    {
        return (new Otp())->validate($requestData['phone'], $requestData['otp']);
    }

    public function verifyeUserAccount($requestData)
    {
        $user = $this->getUserBy('phone', $requestData['phone']);

        if ($user) $user->update(['email_verified_at' => now()]);
    }

    public function changePassword($requestData)
    {
        $user = $this->getUserBy('email', $requestData['email']);

        $otp = (new Otp())->validate($requestData['email'], $requestData['otp']);

        if ($user && isset($otp->status) && $otp->status === true) {

            $newPassword = bcrypt($requestData['password']);

            $user->password = $newPassword;

            $user->save();

            return $user;
        }

        return null;
    }

    public function logout(Request $request)
    {
        if (auth()->check()) $request->user()->tokens()->delete();
    }

    public function deleteAccount()
    {
        return $this->user->delete();
    }

    private function getUserBy($filter, $value)
    {
        return User::where($filter, $value)->first();
    }

    private function createUserAvatar($user)
    {
        Media::create([
            'mediable_id' => $user->id,
            'mediable_type' => $user::class,
            'name' => "images/avatar.jpeg",
            'type' => "jpeg",
            'path' => "avatar.jpeg",
            'size' => "11.8 KB",
            'attribute' => "avatar"
        ]);
    }

    private function getUserData($authUser)
    {
        $expires_at = now()->addMinutes(config('sanctum.expiration'));

        $data['id'] = $authUser->id;
        $data['name'] = $authUser->name;
        $data['surname'] = $authUser->surname;
        $data['phone'] = $authUser->phone;
        $data['email'] = $authUser->email;
        $data['user_type'] = $authUser->user_type;
        $data['avatar'] = $authUser->avatar;
        $data['token'] = $this->createApiToken($authUser, $expires_at);
        $data['token_type'] = 'Bearer';
        $data['token_expires_at'] = $expires_at->toDateTimeString();
        return $data;
    }

    private function createApiToken($user, $expires_at)
    {
        return $user->createToken($user->email, ['*'], $expires_at)->plainTextToken;
    }

    private function sendMail($path, $data, $email, $subject)
    {
        Mail::send(
            $path,
            $data,
            function($message) use($email, $subject){
                $message->to($email);
                $message->subject($subject);
            }
        );
    }
}
