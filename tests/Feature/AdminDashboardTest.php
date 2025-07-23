<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminDashboardTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_admin_can_see_pending_requests_on_the_dashboard()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $pendingUser = User::factory()->create(['role' => 'contractor_pending']);

        $response = $this->actingAs($admin)->get('/admin/dashboard');

        $response->assertSee($pendingUser->company_name);
    }

    /** @test */
    public function an_admin_can_approve_a_pending_request()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $pendingUser = User::factory()->create(['role' => 'contractor_pending']);

        $this->actingAs($admin)->post('/admin/approve/' . $pendingUser->id);

        $this->assertDatabaseHas('users', [
            'id' => $pendingUser->id,
            'role' => 'contractor_approved',
        ]);

        $this->assertDatabaseHas('stands', [
            'user_id' => $pendingUser->id,
        ]);
    }

    /** @test */
    public function an_admin_can_reject_a_pending_request()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $pendingUser = User::factory()->create(['role' => 'contractor_pending']);

        $this->actingAs($admin)->delete('/admin/reject/' . $pendingUser->id);

        $this->assertDatabaseMissing('users', [
            'id' => $pendingUser->id,
        ]);
    }
}
