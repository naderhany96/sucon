<?php

namespace Database\Factories;

use App\Models\AgeGroup;
use Illuminate\Database\Eloquent\Factories\Factory;

class AgeGroupFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = AgeGroup::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $ranges = [
            ['range' => '6-12',  'from' => '6',  'to' => '12'],
            ['range' => '13-17', 'from' => '13', 'to' => '17'],
            ['range' => '18-25', 'from' => '18', 'to' => '25'],
            ['range' => '26-40', 'from' => '26', 'to' => '40'],
            ['range' => '41-64', 'from' => '41', 'to' => '64'],
            ['range' => '66+',   'from' => '66', 'to' => '150' ],
        ];

        return $this->faker->unique()->randomElement($ranges);
    }
}
