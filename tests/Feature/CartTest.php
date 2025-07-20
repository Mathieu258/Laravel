<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_visitor_can_add_a_product_to_the_cart()
    {
        $product = Product::factory()->create();

        $this->post('/cart/add/' . $product->id, [
            'quantity' => 1,
        ]);

        $this->assertCount(1, session('cart'));
    }

    /** @test */
    public function a_visitor_can_remove_a_product_from_the_cart()
    {
        $product = Product::factory()->create();

        $this->post('/cart/add/' . $product->id, [
            'quantity' => 1,
        ]);

        $this->delete('/cart/remove/' . $product->id);

        $this->assertCount(0, session('cart'));
    }

    /** @test */
    public function a_visitor_can_place_an_order()
    {
        $product = Product::factory()->create();

        $this->post('/cart/add/' . $product->id, [
            'quantity' => 1,
        ]);

        $this->post('/cart/place-order');

        $this->assertDatabaseHas('orders', [
            'stand_id' => $product->stand_id,
        ]);

        $this->assertCount(0, session('cart'));
    }
}
