<?php

namespace Database\Factories;

use App\Models\{
    User,
    DoctorProfile
};
use Illuminate\Database\Eloquent\Factories\Factory;

class DoctorProfileFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = DoctorProfile::class;

    public function definition(): array
    {
        return [
            'about' => $this->faker->text,
            'price' => $this->faker->randomFloat(0, 0, 999),
            'yoe' => $this->faker->numberBetween(1, 50),
            'user_id' => User::factory(),
        ];
    }
}
