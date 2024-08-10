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

    public function getStatusAttribute($value)
    {
        $statuses = [
            'pending' => 'pendiente',
            'accepted' => 'aceptado',
            'in progress' => 'en progreso',
            'delivered' => 'entregado',
            'cancelled' => 'cancelado',
        ];

        return $statuses[$value] ?? $value;
    }

    public function getStatusColorAttribute()
    {
        return match ($this->status) {
            'pendiente' => 'yellow',
            'aceptado' => 'blue',
            'en progreso' => 'blue',
            'entregado' => 'green',
            'cancelado' => 'red',
            default => 'gray',
        };
    }
}
