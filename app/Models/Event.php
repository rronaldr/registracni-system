<?php

namespace App\Models;

use App\Enums\Event\EventStatusEnum;
use App\Enums\Event\EventTypeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'template',
        'description',
        'status',
        'type',
        'c_fields',
        'blacklist_id',
    ];

    protected $casts = [
        'type' => 'integer'
    ];

    public function blacklist(): BelongsTo
    {
        return $this->belongsTo(Blacklist::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    public function template(): BelongsTo
    {
        return $this->BelongsTo(Template::class);
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function dates(): HasMany
    {
        return $this->hasMany(Date::class);
    }

    public function enrollments(): HasManyThrough
    {
        return $this->hasManyThrough(Enrollment::class, Date::class);
    }

    public function users(): HasManyThrough
    {
        return $this->hasManyThrough(User::class, Enrollment::class);
    }
}
