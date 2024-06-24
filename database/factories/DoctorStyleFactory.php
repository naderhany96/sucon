<?php

namespace Database\Factories;

use App\Models\{
    DoctorStyle,
    WorkingStyle,
    DoctorProfile
};
use Illuminate\Database\Eloquent\Factories\Factory;

class DoctorStyleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = DoctorStyle::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'profile_id' => DoctorProfile::factory(),
            'style_id' => WorkingStyle::factory(),
        ];
    }
}
