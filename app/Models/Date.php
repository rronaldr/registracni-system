<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Date extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * @var array
     */
    protected $fillable = [
        'event_id',
        'name',
        'capacity',
        'date_start',
        'date_end',
        'enrollment_start',
        'enrollment_end',
        'withdraw_end',
        'location',
        'substitute'
    ];

    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class);
    }

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function getSignedCount(): int
    {
        return $this->enrollments()->where('state', 1)->count();
    }

    public function hasUserEnrolled(int $userId): bool
    {
        return $this->enrollments()->where('user_id', $userId)->first() !== null;
    }
}
