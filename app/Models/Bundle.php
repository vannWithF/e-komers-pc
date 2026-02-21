<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Bundle extends Model
{

    protected $fillable = ['name', 'theme', 'description', 'price', 'image'];

    public function cartItems()
{
    return $this->hasMany(CartItem::class);
}

}
