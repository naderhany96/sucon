<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $fillable = ['mediable_id','mediable_type','name', 'type', 'path', 'size','attribute'];

    protected $hidden   = ['mediable_id', 'mediable_type'];

    protected $appends  = ['fullpath'];

    public function mediable()
    {
        return $this->morphTo();
    }

    public function getFullpathAttribute($value)
    {
        return asset('uploads/' . $this->path);
    }

    public function getFullpathimgAttribute($value)
    {
        return asset('uploads/images/' . $this->path);
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d h:i A');
    }

    public static function boot() {
        parent::boot();
        static::deleting(function($mediaFile) {
            if (File::exists(public_path('uploads/'.$mediaFile->path))) {
                File::delete(public_path('uploads/'.$mediaFile->path));
            }
        });
    }
}
