<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AvailableAddress extends Model
{
    /**
     * Get the vendor that owns the AvailableAddress
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Shop::class);
    }
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
