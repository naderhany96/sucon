<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 15 doctors
        // you must call this twice for randomization
        User::factory()->doctor()->count(1)->create();
        User::factory()->doctor()->count(1)->create();
        User::factory()->doctor()->count(1)->create();
        User::factory()->doctor()->count(1)->create();
        User::factory()->doctor()->count(1)->create();
        User::factory()->doctor()->count(1)->create();
        User::factory()->doctor()->count(1)->create();
        User::factory()->doctor()->count(1)->create();
        User::factory()->doctor()->count(1)->create();
        User::factory()->doctor()->count(1)->create();
        User::factory()->doctor()->count(1)->create();
        User::factory()->doctor()->count(1)->create();
        User::factory()->doctor()->count(1)->create();
        User::factory()->doctor()->count(1)->create();
        User::factory()->doctor()->count(1)->create();

        // 5 patients
        User::factory()->patient()->count(5)->create();
    }
}
