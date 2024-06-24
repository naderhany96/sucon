<?php

namespace Database\Factories;

use App\Models\SpeakingLanguage;
use Illuminate\Database\Eloquent\Factories\Factory;

class SpeakingLanguageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SpeakingLanguage::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $langs = [
            "English", 
            'Arabic',
            'French',
            'Span',
        ];

        $lang = $this->faker->unique()->randomElement($langs);

        return [
            'lang' => $lang
        ];
    }
}
