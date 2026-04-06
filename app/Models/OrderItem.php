<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Model OrderItem untuk menyimpan rincian produk dalam satu pesanan.
 * Berguna sebagai 'snapshot' harga saat transaksi dilakukan.
 */
class OrderItem extends Model
{
    protected $fillable = [
        'order_id',
        'product_id',
        'price',    // Harga produk saat dibeli
        'quantity', // Jumlah beli
        'subtotal'  // price * quantity
    ];

    /**
     * Produk terkait.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}

