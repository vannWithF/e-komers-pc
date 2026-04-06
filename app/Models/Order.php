<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Model Order untuk menyimpan transaksi/pesanan user.
 */
class Order extends Model
{
    protected $fillable = [
        'user_id',
        'invoice',       // Kode Invoice (misal: INV-XXXXX)
        'total_price',   // Total harga (produk + ongkir)
        'shipping_cost', // Ongkos kirim
        'status',        // Status Pesanan: pending, paid, shipped, completed
        'logistic_status',
        'shipped_at',
        'delivered_at',
    ];

    protected $casts = [
        'shipped_at' => 'datetime',
        'delivered_at' => 'datetime',
    ];

    /**
     * Item-item produk yang dibeli dalam pesanan ini.
     */
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * User yang melakukan pemesanan.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
