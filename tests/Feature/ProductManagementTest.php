<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Stand;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductManagementTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_approved_contractor_can_add_a_product()
    {
        $contractor = User::factory()->create(['role' => 'contractor_approved']);
        $stand = Stand::factory()->create(['user_id' => $contractor->id]);

        $this->actingAs($contractor)->post('/entrepreneur/products', [
            'name' => 'New Product',
            'description' => 'Product description',
            'price' => 12.34,
        ]);

        $this->assertDatabaseHas('products', [
            'name' => 'New Product',
            'stand_id' => $stand->id,
        ]);
    }

    /** @test */
    public function an_approved_contractor_can_edit_their_product()
    {
        $contractor = User::factory()->create(['role' => 'contractor_approved']);
        $stand = Stand::factory()->create(['user_id' => $contractor->id]);
        $product = Product::factory()->create(['stand_id' => $stand->id]);

        $this->actingAs($contractor)->put('/entrepreneur/products/' . $product->id, [
            'name' => 'Updated Product',
            'description' => 'Updated description',
            'price' => 56.78,
        ]);

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'name' => 'Updated Product',
        ]);
    }

    /** @test */
    public function an_approved_contractor_can_delete_their_product()
    {
        $contractor = User::factory()->create(['role' => 'contractor_approved']);
        $stand = Stand::factory()->create(['user_id' => $contractor->id]);
        $product = Product::factory()->create(['stand_id' => $stand->id]);

        $this->actingAs($contractor)->delete('/entrepreneur/products/' . $product->id);

        $this->assertDatabaseMissing('products', [
            'id' => $product->id,
        ]);
    }
}
