<?php

namespace Database\Seeders;

use App\Models\WorkingStyle;
use Illuminate\Database\Seeder;

class WorkingStyleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        WorkingStyle::factory()->count(6)->create();
    }
}
