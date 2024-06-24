<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePatientRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            "surname"    =>  "filled|string|max:190",
            "name"    => "filled|string|max:190",
            "dob"    => "filled|date_format:Y-m-d",
            "gender"  => "filled|in:male,female",

        ];
    }
}
