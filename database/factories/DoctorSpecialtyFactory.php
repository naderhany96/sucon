<?php

namespace Database\Factories;

use App\Models\{
    Specialty,
    DoctorProfile,
    DoctorSpecialty
};
use Illuminate\Database\Eloquent\Factories\Factory;

class DoctorSpecialtyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = DoctorSpecialty::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'profile_id' => DoctorProfile::factory(),
            'specialty_id' => Specialty::factory(),
        ];
    }
}
