<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShoppingCart extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'quantity', 'total_price'];

    public function products()
    {
        return $this->belongsToMany(Product::class)->using(ProductShoppingCart::class)->withPivot('quantity', 'total_price');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
