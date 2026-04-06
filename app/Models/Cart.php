<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Model Cart untuk menyimpan informasi keranjang belanja user di database.
 */
class Cart extends Model
{
    protected $fillable = ['user_id'];

    /**
     * Relasi ke model User.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke item-item di dalam keranjang.
     */
    public function items()
    {
        return $this->hasMany(CartItem::class);
    }
}
