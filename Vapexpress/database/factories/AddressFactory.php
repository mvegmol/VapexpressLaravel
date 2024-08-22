<?php

namespace Database\Factories;

use App\Models\Address;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class AddressFactory extends Factory
{
    protected $model = Address::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'full_name' => $this->faker->name,
            'direction' => $this->faker->address,
            'city' => $this->faker->city,
            'province' => $this->faker->state,
            'zip_code' => $this->faker->postcode,
            'contact_phone' => $this->faker->phoneNumber,
            'is_default' => $this->faker->boolean,
        ];
    }
}
