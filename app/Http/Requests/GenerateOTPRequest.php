<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GenerateOTPRequest extends FormRequest
{
   
    public function rules()
    {
        return [
            "phone" => ['nullable', 'between:1,15'],
            "email" => ['required', 'email', 'exists:users,email'],
        ];
    }
}
