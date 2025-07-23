<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_visitor_can_register_as_a_pending_contractor()
    {
        $this->post('/register', [
            'name' => 'John Doe',
            'company_name' => 'Doe Inc.',
            'email' => 'john@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $this->assertDatabaseHas('users', [
            'email' => 'john@example.com',
            'role' => 'contractor_pending',
        ]);
    }
}
