<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * @var array
     */
    protected $fillable = [
        'xname',
        'absolvent_id',
        'first_name',
        'last_name',
        'roles',
        'email',
        'password',
    ];

    /**
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(UserRole::class)->withTimestamps();
    }

    public function enrolments(): HasMany
    {
        return $this->hasMany(Enrollment::class);
    }

    public function blacklists(): HasMany
    {
        return $this->hasMany(Blacklist::class);
    }
}
