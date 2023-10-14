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
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;

class Event extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'template_id',
        'blacklist_id',
        'user_id',
        'name',
        'subtitle',
        'calendar_id',
        'contact_person',
        'contact_email',
        'template',
        'description',
        'status',
        'type',
        'c_fields',
        'template_content',
        'global_blacklist',
        'event_blacklist',
        'user_group',
        'date_start_cache',
        'date_end_cache'
    ];

    protected $casts = [
        'type' => 'integer',
        'c_fields' => 'array',
    ];

    public function getTagsCollection(): Collection
    {
        return collect($this->c_fields);
    }

    public function blacklist(): BelongsTo
    {
        return $this->belongsTo(Blacklist::class);
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
