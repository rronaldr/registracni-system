<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * @var array
     */
    protected $fillable = [
        'shibboleth_id',
        'xname',
        'absolvent_id',
        'empl_id',
        'first_name',
        'last_name',
        'roles',
        'email',
        'password',
        'display_name',
        'entitlement'
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

    public function getFullname(): string
    {
        return isset($this->display_name)
            ? $this->display_name
            : sprintf("%s %s", $this->first_name, $this->last_name);
    }

    public function isExternalUser(): bool
    {
        return empty($this->xname) && !empty($this->password);
    }

    public function events(): HasMany
    {
        return $this->hasMany(Event::class);
    }

    public function templates(): HasMany
    {
        return $this->hasMany(Template::class);
    }

    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class);
    }

    public function blacklists(): BelongsToMany
    {
        return $this->belongsToMany(Blacklist::class)->withTimestamps()->withPivot(['block_reason', 'blocked_until']);
    }

    public function collaborations(): BelongsToMany
    {
        return $this->belongsToMany(Event::class)->withTimestamps();
    }
}
