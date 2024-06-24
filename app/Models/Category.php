<?php

namespace App\Models;

use App\Models\User;
use Wildside\Userstamps\Userstamps;
use Illuminate\Database\Eloquent\Model;
use Rennokki\QueryCache\Traits\QueryCacheable;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;

class Category extends Model
{
    use Userstamps;
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
    public $cacheTags = ['category'];

    /**
     * A cache prefix string that will be prefixed
     * on each cache key generation.
     *
     * @var string
     */
    public $cachePrefix = 'category_';

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
    protected $appends = ['image'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'name',
        'parent_id',
        'created_by',
        'updated_by',
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

    public function media(): \Illuminate\Database\Eloquent\Relations\morphMany
    {
        return $this->morphMany(Media::class, 'mediable');
    }

    public function getImageAttribute(): ?string
    {
        return $this->media->where('attribute', 'image')->first()?->fullpath;
    }
    
    public function scopeParenstOnly($query)
    {
        return $query->whereNull('parent_id');
    }
    
    public function scopeChildrensOnly($query)
    {
        return $query->whereNotNull('parent_id');
    }

    public function children(): \Illuminate\Database\Eloquent\Relations\hasMany
    {
      return $this->hasMany(self::class, 'parent_id');
    }

    public function parent(): \Illuminate\Database\Eloquent\Relations\hasOne
    {
      return $this->hasOne(self::class, 'id', 'parent_id');
    }

    public function users(): \Illuminate\Database\Eloquent\Relations\belongsToMany
    {
        return $this->belongsToMany(User::class,'user_categories','category_id','user_id');
    }

    public static function boot() {
        parent::boot();

        static::deleting(function($category) {

            if ($category->media != null) 
                foreach ($category->media as $mediafile) 
                    $mediafile->delete();

            if ($category->users != null) 
                $category->users()->detach();
        
        });
    }
}
