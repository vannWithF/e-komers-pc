<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SetupItem extends Model
{
    protected $fillable = [
        'setup_id',
        'product_id'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}

