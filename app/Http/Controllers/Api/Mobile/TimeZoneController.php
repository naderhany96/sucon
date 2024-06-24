<?php

namespace App\Http\Controllers\Api\Mobile;

use App\Http\Controllers\ApiController;
use App\Models\TimeZone;

class TimeZoneController extends ApiController
{
    public function __invoke()
    {
        $timeZones = TimeZone::get(['id', 'name']);
        return $timeZones;
    }
}
