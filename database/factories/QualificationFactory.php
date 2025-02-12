<?php

namespace Database\Factories;

use App\Models\Qualification;
use Illuminate\Database\Eloquent\Factories\Factory;

class QualificationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Qualification::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $names = [
            "Master's degree", 
            'Ph. D.',
            'Psy. D.',
        ];

        $name = $this->faker->unique()->randomElement($names);

        return [
            'name' => $name
        ];
    }
}
