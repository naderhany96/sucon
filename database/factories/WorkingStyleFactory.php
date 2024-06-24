<?php

namespace Database\Factories;

use App\Models\WorkingStyle;
use Illuminate\Database\Eloquent\Factories\Factory;

class WorkingStyleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = WorkingStyle::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $stylies = [
            [
                'name' => 'Acceptance and Commitment (ACT)', 
                'desc' => 'Embrace thoughts and feelings instead of feeling guilty'
            ],
            [
                'name' => 'Adlerian', 
                'desc' => 'Develop ways to feel more connected to others'
            ],
            [
                'name' => 'Applied Behavioural Analysis', 
                'desc' => 'Improve specific behaviors'
            ],
            [
                'name' => 'Attachment-based', 
                'desc' => 'Explore how childhood experiences impact adult relationships'
            ],
            [
                'name' => 'Cognitive Behavioural (CBT)', 
                'desc' => 'Identify and change negative thinking'
            ],
            [
                'name' => 'Dialectical (DBT)', 
                'desc' => 'Push for positive behavioral changes'
            ],
        ];

        return $this->faker->unique()->randomElement($stylies);
    }
}
