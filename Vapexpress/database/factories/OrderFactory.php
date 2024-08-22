<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Order;
use App\Models\User;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(), // assuming you have a User factory
            'total_price' => $this->faker->randomFloat(2, 20, 500),
            'address' => $this->faker->address,
            'status' => $this->faker->randomElement(['pending', 'accepted', 'in progress', 'delivered', 'cancelled']),
            'order_date' => $this->faker->dateTime,
        ];
    }
}
