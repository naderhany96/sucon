<?php

namespace Database\Factories;

use App\Models\{
    DoctorProfile,
    Qualification,
    DoctorQualification
};
use Illuminate\Database\Eloquent\Factories\Factory;

class DoctorQualificationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = DoctorQualification::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'profile_id' => DoctorProfile::factory(),
            'qualification_id' => Qualification::factory(),
        ];
    }
}
