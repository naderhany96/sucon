<?php

namespace App\Models;

use App\Models\{
    DoctorProfile,
    Qualification
};
use Wildside\Userstamps\Userstamps;
use Illuminate\Database\Eloquent\Model;
use Rennokki\QueryCache\Traits\QueryCacheable;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DoctorQualification extends Model
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
    public $cacheTags = ['doctor_qualification'];

    /**
     * A cache prefix string that will be prefixed
     * on each cache key generation.
     *
     * @var string
     */
    public $cachePrefix = 'doctor_qualification_';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'profile_id',
        'qualification_id',
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

    public function profile(): \Illuminate\Database\Eloquent\Relations\belongsTo
    {
        return $this->belongsTo(DoctorProfile::class, 'profile_id');
    }

    public function qualification(): \Illuminate\Database\Eloquent\Relations\belongsTo
    {
        return $this->belongsTo(Qualification::class, 'qualification_id');
    }
}
