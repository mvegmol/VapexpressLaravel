<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }


    public function address()
    {
        return $this->hasMany(Address::class);
    }

    public function shoppingCart()
    {
        return $this->hasOne(ShoppingCart::class);
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }
    public function cartQuantity()
    {
        $cart = $this->shoppingCart;
        if ($cart && $cart->products()->exists()) {
            // Sumar la cantidad de productos en el carrito
            return $cart->products->sum('pivot.quantity');
        }
        return 0;
    }

    public function favouriteProducts()
    {
        return $this->belongsToMany(Product::class, 'favourite_product', 'user_id', 'product_id');
    }

    public function favoriteQuantity()
    {
        $favorite = $this->favouriteProducts->count();;
        return $favorite;
    }
}
