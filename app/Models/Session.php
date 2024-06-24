<?php

namespace App\Models;

use App\Models\User;
use Wildside\Userstamps\Userstamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Session extends Model
{
    use HasFactory, SoftDeletes, Userstamps;




    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'name',
        'duration',
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
        'created_at' => 'date:Y-m-d h:i A',
        'updated_at' => 'date:Y-m-d h:i A',
        'deleted_at' => 'date:Y-m-d h:i A',
    ];

    public function doctorSessions(): \Illuminate\Database\Eloquent\Relations\belongsToMany
    {
        return $this->belongsToMany(User::class, 'doctor_sessions','session_id','user_id');
    }
}
