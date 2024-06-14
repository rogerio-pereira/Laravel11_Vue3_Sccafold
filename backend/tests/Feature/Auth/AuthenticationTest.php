<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_users_can_authenticate_using_the_login_screen(): void
    {
        $user = User::factory()->create();

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertJson([
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
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

    public function test_users_when_authenticate_generate_a_new_token(): void
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

    public function test_users_can_not_authenticate_with_invalid_password(): void
    {
        $user = User::factory()->create();

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
    }

    public function test_users_can_logout(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/logout');

        $this->assertGuest();
        $response->assertNoContent();
    }
}
