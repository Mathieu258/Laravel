<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Stand;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ShowcaseTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_visitor_can_see_the_list_of_approved_exhibitors()
    {
        $approvedContractor = User::factory()->create(['role' => 'contractor_approved']);
        $stand = Stand::factory()->create(['user_id' => $approvedContractor->id]);

        $response = $this->get('/exhibitors');

        $response->assertSee($stand->stand_name);
    }

    /** @test */
    public function a_visitor_cannot_see_the_stands_of_pending_or_rejected_contractors()
    {
        $pendingContractor = User::factory()->create(['role' => 'contractor_pending']);
        Stand::factory()->create(['user_id' => $pendingContractor->id, 'stand_name' => 'Pending Stand']);

        $response = $this->get('/exhibitors');

        $response->assertDontSee('Pending Stand');
    }

    /** @test */
    public function a_visitor_can_see_the_products_on_a_stand_page()
    {
        $approvedContractor = User::factory()->create(['role' => 'contractor_approved']);
        $stand = Stand::factory()->create(['user_id' => $approvedContractor->id]);
        $product = Product::factory()->create(['stand_id' => $stand->id]);

        $response = $this->get('/stand/' . $stand->id);

        $response->assertSee($product->name);
    }
}
