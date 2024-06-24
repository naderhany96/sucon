<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SessionRangeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ranges = [
            ['id' => 1, 'name' => 'Morning', 'range' => '06:00 - 12:00',  'from' => '06:00',  'to' => '12:00'],
            ['id' => 2, 'name' => 'Afternoon', 'range' => '12:00 - 18:00',  'from' => '12:00',  'to' => '18:00'],
            ['id' => 3, 'name' => 'Evening', 'range' => '18:00 - 00:00',  'from' => '18:00',  'to' => '24:00'],
            ['id' => 4, 'name' => 'Night Time', 'range' => '00:00 - 06:00',  'from' => '00:00',  'to' => '06:00'],
        ];
        DB::table('session_ranges')->insert($ranges);
    }
}
