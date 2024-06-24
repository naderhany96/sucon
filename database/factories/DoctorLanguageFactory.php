<?php

namespace Database\Factories;

use App\Models\{
    DoctorProfile,
    DoctorLanguage,
    SpeakingLanguage
};
use Illuminate\Database\Eloquent\Factories\Factory;

class DoctorLanguageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = DoctorLanguage::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'profile_id' => DoctorProfile::factory(),
            'lang_id' => SpeakingLanguage::factory(),
        ];
    }
}
