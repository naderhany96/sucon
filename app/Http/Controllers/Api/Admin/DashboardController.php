<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\ApiController;

class DashboardController extends ApiController
{
    public function index()
    {
        return [
            'countersChart' => [
                'first'  => rand(1, 50),
                'second' => rand(1, 50),
                'third'  => rand(1, 50),
                'forth'  => rand(1, 50),
            ],
            'barChart' => [
                [
                    'name' => 'Net Profit',
                    'data' => $this->randomArrayOfNumbers(1, 6)
                ],
                [
                    'name' => 'Revenue',
                    'data' => $this->randomArrayOfNumbers(1, 6)
                ],
                [
                    'name' => 'Free Cash Flow',
                    'data' => $this->randomArrayOfNumbers(1, 6)
                ]
            ],
            'pieChart1' => $this->randomArrayOfNumbers(1, rand(2, 5)),
            'pieChart2' => $this->randomArrayOfNumbers(1, rand(2, 5)),
        ];
    }

    private function randomArrayOfNumbers($start, $end)
    {
        $random_number_array = range(0, 100);
        shuffle($random_number_array );
        return array_slice($random_number_array , $start, $end);
    }
}
