<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValidateOTPRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            "phone" => ['nullable', 'between:1,15'],
            "otp" => ['required', 'digits:6']
        ];
    }
}
