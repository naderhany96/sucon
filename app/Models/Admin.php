<?php

namespace App\Models;

use DateTimeInterface;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Rennokki\QueryCache\Traits\QueryCacheable;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use HasRoles, HasApiTokens, Notifiable;
    use QueryCacheable, Cachable;

    protected $guard_name = 'admin';

    protected $fillable = ['email','name','mobile_phone','role', 'password', 'isActive'];
    protected $hidden = ['password'];

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
    public $cacheTags = ['admin'];

    /**
     * A cache prefix string that will be prefixed
     * on each cache key generation.
     *
     * @var string
     */
    public $cachePrefix = 'admin_';

    public function insertPermissions(array $permissions)
    {
        $this->givePermissionTo($permissions);
    }

    public function scopeActive($query)
    {
        return $query->where('isActive', 1);
    }

    public function scopeNotActive($query)
    {
        return $query->where('isActive', 0);
    }

    public function scopeSuperAdmin($query)
    {
        return $query->where('isSuperAdmin', 1);
    }

    public function scopeNotSuperAdmin($query)
    {
        return $query->where('isSuperAdmin', 0);
    }

    public function canJoinRoom($room_id)
    {
        return true;
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d h:i A');
    }
}
