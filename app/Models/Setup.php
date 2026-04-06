<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Model Setup untuk mewakili kombinasi PC yang sudah dikonfigurasi (Pre-built).
 */
class Setup extends Model
{
    protected $fillable = [
        'name',
        'description',
        'image',
        'price',
        'is_active' // Status apakah setup ini ditampilkan di toko
    ];

    /**
     * Relasi ke SetupItem (table perantara/pivot manual).
     */
    public function items()
    {
        return $this->hasMany(SetupItem::class);
    }

    /**
     * Relasi many-to-many ke Product untuk mendapatkan daftar komponen dalam setup ini.
     */
    public function products()
    {
        return $this->belongsToMany(Product::class, 'setup_items');
    }
}
