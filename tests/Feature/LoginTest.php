<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_admin_can_login_and_is_redirected_to_the_admin_dashboard()
    {
        $admin = User::factory()->create([
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        $response = $this->post('/login', [
            'email' => 'admin@example.com',
            'password' => 'password',
        ]);

        $response->assertRedirect('/admin/dashboard');
        $this->assertAuthenticatedAs($admin);
    }

    /** @test */
    public function an_approved_contractor_can_login_and_is_redirected_to_the_entrepreneur_dashboard()
    {
        $contractor = User::factory()->create([
            'email' => 'approved@example.com',
            'password' => Hash::make('password'),
            'role' => 'contractor_approved',
        ]);

        $response = $this->post('/login', [
            'email' => 'approved@example.com',
            'password' => 'password',
        ]);

        $response->assertRedirect('/entrepreneur/dashboard');
        $this->assertAuthenticatedAs($contractor);
    }

    /** @test */
    public function a_pending_contractor_cannot_login()
    {
        User::factory()->create([
            'email' => 'pending@example.com',
            'password' => Hash::make('password'),
            'role' => 'contractor_pending',
        ]);

        $response = $this->post('/login', [
            'email' => 'pending@example.com',
            'password' => 'password',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }
}
