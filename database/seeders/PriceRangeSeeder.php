<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PriceRangeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ranges = [
            ['id' => 1, 'name' => '41-103 USD per session', 'range' => '41 - 103',  'from' => '41',  'to' => '103'],
            ['id' => 2, 'name' => '103-154 USD per session', 'range' => '103 - 154',  'from' => '103',  'to' => '154'],
            ['id' => 3, 'name' => '154+ USD per session', 'range' => '154+',  'from' => '154',  'to' => '999999'],
        ];
        DB::table('price_ranges')->insert($ranges);
    }
}
