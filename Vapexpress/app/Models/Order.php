<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        "user_id",
        "total_price",
        "address",
        "status",
        "order_date",
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class)->withPivot(
            "quantity",
            "price"
        );
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
