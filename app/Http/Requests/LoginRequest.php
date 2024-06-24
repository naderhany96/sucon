<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'email' => ['required', 'max:250'],
            'password' => ['required', 'min:4', 'max:250'],
            'time_zone_id' => ['nullable', 'exists:time_zones,id'],
        ];
    }
}
