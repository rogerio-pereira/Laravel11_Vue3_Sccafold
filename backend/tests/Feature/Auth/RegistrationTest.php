<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_new_users_can_register(): void
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertStatus(201);
        $response->assertJson([
                'user' => [
                    'name' => 'Test User',
                    'email' => 'test@example.com',
                ]
            ])
            ->assertJsonStructure([
                'user' => [
                    'name',
                    'email',
                    'role',
                    'token',    //Must Contain a token
                ]
            ]);
    }

    public function test_users_when_register_generate_a_new_token(): void
    {
        $user = User::factory()->create();

        $this->assertDatabaseMissing('personal_access_tokens', [
            'id' => 1,
            'tokenable_type' => 'App\Models\User',
            'tokenable_id' => $user->id,
        ]);

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticated();

        $this->assertDatabaseHas('personal_access_tokens', [
            'id' => 1,
            'tokenable_type' => 'App\Models\User',
            'tokenable_id' => $user->id,
        ]);
    }
}
