<?php

namespace Database\Seeders;

use App\Models\SpeakingLanguage;
use Illuminate\Database\Seeder;

class SpeakingLanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SpeakingLanguage::factory()->count(4)->create();
    }
}
