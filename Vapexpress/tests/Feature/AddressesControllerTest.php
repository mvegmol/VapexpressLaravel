<?php

namespace Tests\Feature;

use App\Models\Address;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AddressesControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);
    }

    /** @test */
    public function test_index_method_for_authenticated_user()
    {
        $user = User::factory()->create(['role' => 'user']);
        $this->actingAs($user);

        $address = Address::factory()->create(['user_id' => $user->id]);

        $response = $this->get(route('addresses.index'));

        $response->assertStatus(200)
            ->assertViewIs('addresses.index')
            ->assertViewHas('addresses', function ($addresses) use ($address) {
                return $addresses->contains($address);
            });
    }


    /** @test */
    public function test_create_method_for_authenticated_user()
    {
        $user = User::factory()->create(['role' => 'user']);
        $this->actingAs($user);

        $response = $this->get(route('addresses.create'));

        $response->assertStatus(200)
            ->assertViewIs('addresses.create');
    }


    /** @test */
    public function test_store_method_for_authenticated_user()
    {
        $user = User::factory()->create(['role' => 'user']);
        $this->actingAs($user);

        $data = [
            'full_name' => 'John Doe',
            'contact_phone' => '123456789',
            'direction' => '123 Main St',
            'city' => 'Springfield',
            'province' => 'IL',
            'zip_code' => '62704',
        ];

        $response = $this->post(route('addresses.store'), $data);

        $response->assertRedirect(route('addresses.index'))
            ->assertSessionHas('success', 'Dirección creada correctamente.');

        $this->assertDatabaseHas('addresses', [
            'user_id' => $user->id,
            'full_name' => 'John Doe',
            'contact_phone' => '123456789',
            'direction' => '123 Main St',
            'city' => 'Springfield',
            'province' => 'IL',
            'zip_code' => '62704',
        ]);
    }

    /** @test */
    public function test_edit_method_for_authenticated_user()
    {
        $user = User::factory()->create(['role' => 'user']);
        $this->actingAs($user);

        $address = Address::factory()->create(['user_id' => $user->id]);

        $response = $this->get(route('addresses.edit', $address->id));

        $response->assertStatus(200)
            ->assertViewIs('addresses.edit')
            ->assertViewHas('address', $address);
    }

    /** @test */
    public function test_update_method_for_authenticated_user()
    {
        $user = User::factory()->create(['role' => 'user']);
        $this->actingAs($user);

        $address = Address::factory()->create(['user_id' => $user->id]);

        $data = [
            'full_name' => 'Jane Doe',
            'contact_phone' => '987654321',
            'direction' => '456 Main St',
            'city' => 'Springfield',
            'province' => 'IL',
            'zip_code' => '62704',
        ];

        $response = $this->put(route('addresses.update', $address->id), $data);

        $response->assertRedirect(route('addresses.index'))
            ->assertSessionHas('success', 'Dirección actualizada correctamente.');

        $this->assertDatabaseHas('addresses', [
            'id' => $address->id,
            'full_name' => 'Jane Doe',
            'contact_phone' => '987654321',
            'direction' => '456 Main St',
            'city' => 'Springfield',
            'province' => 'IL',
            'zip_code' => '62704',
        ]);
    }

    /** @test */
    public function test_destroy_method_for_authenticated_user()
    {
        $user = User::factory()->create(['role' => 'user']);
        $this->actingAs($user);

        $address = Address::factory()->create(['user_id' => $user->id, 'is_default' => true]);

        $response = $this->delete(route('addresses.destroy', $address->id));

        $response->assertRedirect(route('addresses.index'))
            ->assertSessionHas('success', 'Dirección eliminada correctamente.');

        $this->assertDatabaseMissing('addresses', ['id' => $address->id]);
    }

    /** @test */
    public function test_change_default_method()
    {
        $user = User::factory()->create(['role' => 'user']);
        $this->actingAs($user);

        $address1 = Address::factory()->create(['user_id' => $user->id, 'is_default' => true]);
        $address2 = Address::factory()->create(['user_id' => $user->id, 'is_default' => false]);

        $response = $this->put(route('addresses.change', $address2->id));

        $response->assertRedirect(route('addresses.index'))
            ->assertSessionHas('success', 'Dirección predeterminada cambiada correctamente.');

        $this->assertDatabaseHas('addresses', ['id' => $address1->id, 'is_default' => false]);
        $this->assertDatabaseHas('addresses', ['id' => $address2->id, 'is_default' => true]);
    }

    /** @test */
    public function test_create_address_method()
    {
        $user = User::factory()->create(['role' => 'user']);
        $this->actingAs($user);

        $response = $this->get(route('cart.addresses'));

        $response->assertStatus(200)
            ->assertViewIs('shoppingCart.address-checkout');
    }

    /** @test */
    public function test_store_address_method()
    {
        $user = User::factory()->create(['role' => 'user']);
        $this->actingAs($user);

        $data = [
            'full_name' => 'John Doe',
            'contact_phone' => '123456789',
            'direction' => '123 Main St',
            'city' => 'Springfield',
            'province' => 'IL',
            'zip_code' => '62704',
        ];

        $response = $this->post(route('cart.address'), $data);

        $response->assertRedirect(route('shopping_cart.checkout'))
            ->assertSessionHas('success', 'Dirección creada correctamente.');

        $this->assertDatabaseHas('addresses', [
            'user_id' => $user->id,
            'full_name' => 'John Doe',
            'contact_phone' => '123456789',
            'direction' => '123 Main St',
            'city' => 'Springfield',
            'province' => 'IL',
            'zip_code' => '62704',
        ]);
    }
}
