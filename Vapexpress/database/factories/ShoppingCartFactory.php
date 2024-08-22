<?php

namespace Database\Factories;

use App\Models\ShoppingCart;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ShoppingCartFactory extends Factory
{
    protected $model = ShoppingCart::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),  // Asumiendo que tienes un factory para User
            'quantity' => $this->faker->numberBetween(1, 10),
            'total_price' => $this->faker->randomFloat(2, 1, 100),
        ];
    }
}
