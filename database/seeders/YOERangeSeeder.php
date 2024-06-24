<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class YOERangeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ranges = [
            ['id' => 1, 'name' => '0-5', 'range' => '0-5',  'from' => '0',  'to' => '5'],
            ['id' => 2, 'name' => '5-10', 'range' => '5-10',  'from' => '5',  'to' => '10'],
            ['id' => 3, 'name' => 'More than 10', 'range' => '10+',  'from' => '10',  'to' => '999999'],
        ];
        DB::table('yoe_ranges')->insert($ranges);
    }
}
