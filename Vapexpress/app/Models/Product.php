<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class)->withPivot('quantity', 'price');
    }

    public function userFavourites()
    {
        return $this->belongsToMany(User::class, 'favourite_product', 'product_id', 'user_id');
    }

    public function shoppingCart()
    {
        return $this->belongsToMany(ShoppingCart::class)->withPivot('quantity', 'total_price');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
}
