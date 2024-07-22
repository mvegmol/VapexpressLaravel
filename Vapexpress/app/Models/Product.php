<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'price', 'stock', 'url_image', 'supplier_id'];

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
    public static function bestSellings()
    {
        return static::select(
            'products.id',
            'products.name',
            'products.description',
            'products.price',
            'products.stock',
            'products.url_image',
            DB::raw('COUNT(orders.id) as total_orders')
        )
            ->leftJoin('order_product', 'products.id', '=', 'order_product.product_id')
            ->leftJoin('orders', 'order_product.order_id', '=', 'orders.id')
            ->groupBy(
                'products.id',
                'products.name',
                'products.description',
                'products.price',
                'products.stock',
                'products.url_image',
            )
            ->orderByDesc('total_orders')
            ->orderBy('products.name', 'asc');
    }
}
