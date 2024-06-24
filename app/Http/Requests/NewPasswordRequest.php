<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NewPasswordRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            "otp" => ['required'],
            "email" => ['required', 'email'],
            "password" => ['required', 'confirmed', 'min:6', 'max:250']
        ];
    }
}
