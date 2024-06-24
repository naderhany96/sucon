<?php

namespace App\Models;

use App\Models\User;
use Wildside\Userstamps\Userstamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Rennokki\QueryCache\Traits\QueryCacheable;
use Dyrynda\Database\Support\CascadeSoftDeletes;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Specialty extends Model
{
    use HasFactory, SoftDeletes, Userstamps;
    use CascadeSoftDeletes;
    use QueryCacheable, Cachable;

    /**
     * Invalidate the cache automatically
     * upon update in the database.
     *
     * @var bool
     */
    protected static $flushCacheOnUpdate = true;

    protected $cascadeDeletes = ['DoctorSpecialties'];

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
    public $cacheTags = ['specialty'];

    /**
     * A cache prefix string that will be prefixed
     * on each cache key generation.
     *
     * @var string
     */
    public $cachePrefix = 'specialty_';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'name',
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

    public function DoctorSpecialties(): \Illuminate\Database\Eloquent\Relations\belongsToMany
    {
        return $this->belongsToMany(User::class, 'doctor_specialties','specialty_id','user_id');
    }
}
