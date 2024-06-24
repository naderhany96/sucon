<?php

namespace App\Models;

use App\Models\{
    User,
    Media
};
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Rennokki\QueryCache\Traits\QueryCacheable;
use Dyrynda\Database\Support\CascadeSoftDeletes;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DoctorProfile extends Model
{
    use HasFactory, SoftDeletes;
    use CascadeSoftDeletes;
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
    public $cacheTags = ['doctor_profile'];

    /**
     * A cache prefix string that will be prefixed
     * on each cache key generation.
     *
     * @var string
     */
    public $cachePrefix = 'doctor_profile_';

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = ['media'];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'intro_video',
        'cover_image',
        'passport',
        'license'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'about',
        'price',
        'yoe',
        'user_id'
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

    
    public function media(): \Illuminate\Database\Eloquent\Relations\morphMany
    {
        return $this->morphMany(Media::class, 'mediable');
    }

    public function getIntroVideoAttribute(): ?string
    {
        return $this->media->where('attribute', 'video')->first()?->fullpath;
    }

    public function getCoverImageAttribute(): ?string
    {
        return $this->media->where('attribute', 'cover_image')->first()?->fullpath;
    }

    public function getPassportAttribute(): ?string
    {
        return $this->media->where('attribute', 'passport')->first()?->fullpath;
    }

    public function getLicenseAttribute(): ?string
    {
        return $this->media->where('attribute', 'license')->first()?->fullpath;
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\belongsTo
    {
        return $this->belongsTo(User::class);
    }
    
    public static function boot() {
        parent::boot();

        static::deleting(function($user) {

            if ($user->media != null) 
                foreach ($user->media as $mediafile) 
                    $mediafile->delete();

        });
    }
}
