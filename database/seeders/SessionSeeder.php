<?php

namespace Database\Seeders;

use App\Models\Specialty;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SessionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sessions = [
            ['id' => 1, 'name' => '25-min session', 'duration' => '25', 'created_at' => now()],
            ['id' => 2, 'name' => '50-min session', 'duration' => '50', 'created_at' => now()],
        ];

        DB::table('sessions')->insert($sessions);
    }
}
