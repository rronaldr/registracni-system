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
        'date_id',
        'user_id',
        'state',
        'c_fields',
    ];

    protected $casts = [
        'c_fields' => 'array'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function date(): BelongsTo
    {
        return $this->belongsTo(Date::class);
    }
}
