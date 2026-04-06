<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Model Product untuk komponen PC.
 */
class Product extends Model
{
    protected $fillable = ['category_id', 'name', 'slug', 'description', 'price', 'stock', 'image'];

    /**
     * Kategori produk.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Item keranjang yang merujuk ke produk ini.
     */
    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }
}
