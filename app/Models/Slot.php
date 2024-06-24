<?php

namespace App\Models;

use App\Models\SlotRange;
use Illuminate\Database\Eloquent\Model;


class Slot extends Model
{

    protected $table = 'doctor_slots';
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

    ];

    public function slotRanges()
    {
        return $this->hasMany(SlotRange::class, 'doctor_slot_id');
    }

    public function doctor()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
