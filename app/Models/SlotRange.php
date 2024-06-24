<?php

namespace App\Models;

use App\Models\Slot;
use Illuminate\Database\Eloquent\Model;


class SlotRange extends Model
{

    protected $table = 'slot_ranges';
    protected $guarded = [];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'created_at' => 'date:Y-m-d h:i A',
        'updated_at' => 'date:Y-m-d h:i A',
        'deleted_at' => 'date:Y-m-d h:i A',
        'time_from' => 'date:H:i',
        'time_to' => 'date:H:i',
    ];

    public function slot()
    {
        return $this->belongsTo(Slot::class, 'doctor_slot_id');
    }
}
