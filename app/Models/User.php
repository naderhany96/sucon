<?php

namespace App\Models;

use App\Models\{
    Media,
    Category,
    DoctorProfile,
    PatientProfile
};
use Laravel\Sanctum\HasApiTokens;
use willvincent\Rateable\Rateable;
use Wildside\Userstamps\Userstamps;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use HasRoles, SoftDeletes, Userstamps;
    use CascadeSoftDeletes;
    use Rateable;

    protected $cascadeDeletes = [
        'patientProfile',
        'doctorProfile'
    ];





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
    protected $appends = ['avatar'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'surname',
        'name',
        'email',
        'phone',
        'gender',
        'dob',
        'pyment_methods',
        'password',
        'user_type',
        'is_active',
        'device_id',
        'email_verified_at',
        'created_by',
        'updated_by',
        'deleted_by',
        'time_zone_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'created_at' => 'date:Y-m-d h:i A',
        'updated_at' => 'date:Y-m-d h:i A',
        'deleted_at' => 'date:Y-m-d h:i A',
        'email_verified_at'  => 'date:Y-m-d h:i A',

    ];

    public function scopeDoctorType($query)
    {
        return $query->where('user_type', 'doctor');
    }

    public function scopePatientType($query)
    {
        return $query->where('user_type', 'patient');
    }

    public function media(): \Illuminate\Database\Eloquent\Relations\morphMany
    {
        return $this->morphMany(Media::class, 'mediable');
    }

    public function getAvatarAttribute(): ?string
    {
        return $this->media->where('attribute', 'avatar')->first()?->fullpath;
    }

    public function patientProfile(): \Illuminate\Database\Eloquent\Relations\hasOne
    {
        return $this->hasOne(PatientProfile::class);
    }

    public function doctorProfile(): \Illuminate\Database\Eloquent\Relations\hasOne
    {
        return $this->hasOne(DoctorProfile::class);
    }

    public function groupTherapists(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(GroupTherapist::class, 'user_id');
    }

    public function joinGroupTherapists()
    {
        return $this->belongsToMany(GroupTherapist::class, 'group_therapist_user');
    }

    public function bookedSlots()
    {
        return $this->hasMany(Booking::class, 'patient_id');
    }

    public function categories(): \Illuminate\Database\Eloquent\Relations\belongsToMany
    {
        return $this->belongsToMany(Category::class, 'user_categories', 'user_id', 'category_id');
    }

    public function ageGroups(): \Illuminate\Database\Eloquent\Relations\belongsToMany
    {
        return $this->belongsToMany(AgeGroup::class, 'doctor_age_groups', 'user_id', 'age_group_id');
    }
    // public function doctorSlots(): \Illuminate\Database\Eloquent\Relations\belongsToMany
    // {
    //     return $this->belongsToMany(Slot::class, 'doctor_slots','user_id','slot_id');
    // }

    public function workingStyles(): \Illuminate\Database\Eloquent\Relations\belongsToMany
    {
        return $this->belongsToMany(WorkingStyle::class, 'doctor_styles', 'user_id', 'style_id');
    }

    public function specialties(): \Illuminate\Database\Eloquent\Relations\belongsToMany
    {
        return $this->belongsToMany(Specialty::class, 'doctor_specialties', 'user_id', 'specialty_id');
    }

    public function qualifications(): \Illuminate\Database\Eloquent\Relations\belongsToMany
    {
        return $this->belongsToMany(Qualification::class, 'doctor_qualifications', 'user_id', 'qualification_id');
    }

    public function speakingLanguages(): \Illuminate\Database\Eloquent\Relations\belongsToMany
    {
        return $this->belongsToMany(SpeakingLanguage::class, 'doctor_languages', 'user_id', 'lang_id');
    }

    public function slots()
    {
        return $this->hasMany(Slot::class);
    }

    public function doctorSessions(): \Illuminate\Database\Eloquent\Relations\belongsToMany
    {
        return $this->belongsToMany(Session::class, 'doctor_sessions', 'user_id', 'session_id');
    }

    public function timeZone()
    {
        return $this->belongsTo(TimeZone::class);
    }

    public static function boot()
    {
        parent::boot();

        static::deleting(function ($user) {

            if ($user->media != null)
                foreach ($user->media as $mediafile)
                    $mediafile->delete();

            if ($user->categories != null)
                $user->categories()->detach();

            if ($user->ageGroups != null)
                $user->ageGroups()->detach();

            if ($user->workingStyles != null)
                $user->workingStyles()->detach();

            if ($user->specialties != null)
                $user->specialties()->detach();

            if ($user->qualifications != null)
                $user->qualifications()->detach();

            if ($user->speakingLanguages != null)
                $user->speakingLanguages()->detach();
        });
    }
}
