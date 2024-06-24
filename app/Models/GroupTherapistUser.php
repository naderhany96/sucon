<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class GroupTherapistUser extends Pivot
{
    protected $table = "group_therapist_user";
    protected $gurarded = [];
    public $timestamps = true;

    public function group()
    {
        return $this->belongsTo(GroupTherapist::class, 'group_therapist_id');
    }

    public function patient()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
