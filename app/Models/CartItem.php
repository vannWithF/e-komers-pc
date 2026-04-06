<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Model CartItem untuk menyimpan detail produk di keranjang.
 */
class CartItem extends Model
{
    protected $fillable = ['cart_id', 'product_id', 'bundle_id', 'qty'];

    /**
     * Relasi ke Cart induk.
     */
    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    /**
     * Relasi ke Product.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Relasi ke Bundle.
     */
    public function bundle()
    {
        return $this->belongsTo(Bundle::class);
    }
}
