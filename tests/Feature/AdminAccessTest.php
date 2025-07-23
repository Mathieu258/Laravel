<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAccessTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Vérifie qu'un utilisateur non admin ne peut pas accéder à la page d'administration.
     */
    public function test_non_admin_cannot_access_admin_dashboard()
    {
        $user = User::factory()->create([
            'role' => 'entrepreneur_approuve',
        ]);

        $response = $this->actingAs($user)->get('/admin');

        $response->assertStatus(403);
        $response->assertSee('Accès refusé');
    }

    /**
     * Vérifie qu'un utilisateur non authentifié est redirigé vers la page de login.
     */
    public function test_guest_is_redirected_to_login()
    {
        $response = $this->get('/admin');
        $response->assertRedirect('/login');
    }
} 