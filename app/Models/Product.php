<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $casts = [
        "images" => "array",
        "categories" => "array"
    ];
    public function shop(): BelongsTo
    {
        return $this->belongsTo(Shop::class);
    }

    public function carts(): HasMany
    {
        return $this->hasMany(Cart::class);
    }
}
