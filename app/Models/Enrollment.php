<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Enrollment extends Model
{
    use HasFactory;
    use SoftDeletes;

    /** @var array $fillable */
    protected $fillable = [
        'state',
        'c_fields',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function date(): BelongsTo
    {
        return $this->belongsTo(Date::class);
    }

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }
}
