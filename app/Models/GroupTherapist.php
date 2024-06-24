<?php

namespace App\Models;

use Wildside\Userstamps\Userstamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class GroupTherapist extends Model
{
    use HasFactory, SoftDeletes, Userstamps;

    protected $table = 'group_therapists';


    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'user_id',
        'title',
        'desc',
        'date',
        'day',
        'duration',
        'seats',
        'price',
        'start_time',
        'finish_time',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'date' => 'date:Y-m-d',
        'time_from' => 'date:Y-m-d h:i A',
        'time_to' => 'date:Y-m-d h:i A',
        'created_at' => 'date:Y-m-d h:i A',
        'updated_at' => 'date:Y-m-d h:i A',
        'deleted_at' => 'date:Y-m-d h:i A',
    ];

    public function joiners()
    {
        return $this->belongsToMany(User::class, 'group_therapist_user');
    }
}
