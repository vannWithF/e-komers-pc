<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setup extends Model
{
    protected $fillable = [
        'name',
        'description',
        'image',
        'is_active'
    ];

    public function items()
    {
        return $this->hasMany(SetupItem::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'setup_items');
    }
}
