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
        'date_start_cache',
        'date_end_cache'
    ];

    protected $casts = [
        'type' => 'integer',
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
