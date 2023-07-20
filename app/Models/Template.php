<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Template extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'html',
        'params',
        'approved'
    ];


    public function hasParams(): bool
    {
        return isset($this->params) || !empty(json_decode($this->params, true));
    }
    public function getParamsAsArray(): ?array
    {
        $params = collect(json_decode($this->params, true));

        if (!isset($params)) {
            return null;
        }

        return $params->toArray();
    }

    public function events(): HasMany
    {
        return $this->hasMany(Event::class);
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

