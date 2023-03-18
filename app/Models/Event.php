<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Event extends Model
{
    use HasFactory;

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'enrolment_from',
        'enrolment_to',
        'c_fields',
        'template',
        'description',
    ];

    public function blacklist(): BelongsTo
    {
        return $this->belongsTo(Blacklist::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    public function dates(): HasMany
    {
        return $this->hasMany(Date::class);
    }
}
