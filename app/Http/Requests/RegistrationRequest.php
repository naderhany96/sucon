<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class RegistrationRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            "surname" => ['nullable', 'string', 'max:250'],
            "name" => ['required', 'string', 'max:250'],
            "user_type" => ['required', Rule::in('doctor', 'patient')],
            "email" => [
                'required',
                'email', Rule::unique('users', 'email')->whereNull('deleted_at')
            ],
            "phone" => [
                'required',
                'between:1,15', Rule::unique('users', 'phone')->whereNull('deleted_at')
            ],
            "password" => ['required', 'min:6', 'max:250'],
            "password_confirmation" => ['required', 'min:6', 'max:250'],
            'time_zone_id' => ['nullable', 'exists:time_zones,id']
        ];
    }
}
