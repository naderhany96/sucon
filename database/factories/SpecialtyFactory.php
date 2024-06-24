<?php

namespace Database\Factories;

use App\Models\Specialty;
use Illuminate\Database\Eloquent\Factories\Factory;

class SpecialtyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Specialty::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $names = [
            "Attention Deficit Hyperactivity Disorder (ADHD)",
            "Adoption",
            "Alzheimer's",
            "Anger Management",
            "Anxiety",
            "Autism Spectrum Disorder",
        ];

        $name = $this->faker->unique()->randomElement($names);

        return [
            'name' => $name
        ];
    }
}
