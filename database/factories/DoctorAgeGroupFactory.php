<?php

namespace Database\Factories;

use App\Models\{
    AgeGroup,
    DoctorProfile,
    DoctorAgeGroup
};
use Illuminate\Database\Eloquent\Factories\Factory;

class DoctorAgeGroupFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = DoctorAgeGroup::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'profile_id' => DoctorProfile::factory(),
            'age_group_id' => AgeGroup::factory(),
        ];
    }
}
