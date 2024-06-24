<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class FindExpertRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            "categories"    => ["nullable", "array"],
            "categories.*"  => ["required", "integer", "distinct"],

            "age_groups"    => ["nullable", "array"],
            "age_groups.*"  => ["nullable", "integer", "distinct"],

            "price_range"    => ["nullable", "array"],
            "price_range.*"  => ["nullable", "integer", "distinct"],

            "languages"     => ["nullable", "array"],
            "languages.*"   => ["nullable", "integer", "distinct"],

            "session_range"     => ["nullable", "array"],
            "session_range.*"   => ["nullable", "integer", "distinct"],

            "gender"        => ["nullable", "array", Rule::in(['male', 'female'])],

        ];
    }
}
