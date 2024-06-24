<?php

namespace Database\Factories;

use App\Models\{
    User,
    PatientProfile
};
use Illuminate\Database\Eloquent\Factories\Factory;

class PatientProfileFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PatientProfile::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::factory(),
        ];
    }
}
