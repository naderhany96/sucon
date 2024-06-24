<?php

namespace App\Models;

use App\Models\{
    Specialty,
    DoctorProfile
};
use Wildside\Userstamps\Userstamps;
use Illuminate\Database\Eloquent\Model;
use Rennokki\QueryCache\Traits\QueryCacheable;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DoctorSpecialty extends Model
{
    use HasFactory, Userstamps;
    use QueryCacheable, Cachable;

    /**
     * Invalidate the cache automatically
     * upon update in the database.
     *
     * @var bool
     */
    protected static $flushCacheOnUpdate = true;
    
    /**
     * Specify the amount of time to cache queries.
     * Do not specify or set it to null to disable caching.
     *
     * @var int|\DateTime
     */
    public $cacheFor = 86400; // 24 hours

    /**
     * The tags for the query cache. Can be useful
     * if flushing cache for specific tags only.
     *
     * @var null|array
     */
    public $cacheTags = ['doctor_specialty'];

    /**
     * A cache prefix string that will be prefixed
     * on each cache key generation.
     *
     * @var string
     */
    public $cachePrefix = 'doctor_specialty_';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'profile_id',
        'specialty_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'created_at' => 'date:Y-m-d h:i A',
        'updated_at' => 'date:Y-m-d h:i A',
    ];

    public function doctor(): \Illuminate\Database\Eloquent\Relations\belongsTo
    {
        return $this->belongsTo(DoctorProfile::class, 'profile_id');
    }

    public function specialty(): \Illuminate\Database\Eloquent\Relations\belongsTo
    {
        return $this->belongsTo(Specialty::class, 'specialty_id');
    }
}
