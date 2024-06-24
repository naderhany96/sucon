<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;

class AppSetting extends Model
{
    protected $fillable = ['commission'];
    protected $table = 'app_settings';

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d h:i A');
    }
}
