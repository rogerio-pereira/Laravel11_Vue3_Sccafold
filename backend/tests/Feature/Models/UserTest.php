<?php

namespace Tests\Feature\Models;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function testCreateTokenWithDefaultName()
    {
        $user = User::factory()->create();

        $this->assertDatabaseMissing('personal_access_tokens', [
            'id' => 1,
            'tokenable_type' => 'App\Models\User',
            'tokenable_id' => $user->id,
            'name' => 'frontend',
        ]);

        $user->newToken();

        $this->assertDatabaseHas('personal_access_tokens', [
            'id' => 1,
            'tokenable_type' => 'App\Models\User',
            'tokenable_id' => $user->id,
            'name' => 'frontend',
        ]);
    }

    public function testCreateTokenWithName()
    {
        $user = User::factory()->create();

        $this->assertDatabaseMissing('personal_access_tokens', [
            'id' => 1,
            'tokenable_type' => 'App\Models\User',
            'tokenable_id' => $user->id,
            'name' => 'new_token',
        ]);

        $user->newToken('new_token');

        $this->assertDatabaseHas('personal_access_tokens', [
            'id' => 1,
            'tokenable_type' => 'App\Models\User',
            'tokenable_id' => $user->id,
            'name' => 'new_token',
        ]);
    }

    public function testDeleteToken()
    {
        $user = User::factory()->create();

        $user->newToken('token_1');
        $user->newToken('token_2');
        $user->newToken('token_3');

        $this->assertDatabaseHas('personal_access_tokens', [
            'id' => 1,
            'tokenable_type' => 'App\Models\User',
            'tokenable_id' => $user->id,
            'name' => 'token_1',
        ]);
        $this->assertDatabaseHas('personal_access_tokens', [
            'id' => 2,
            'tokenable_type' => 'App\Models\User',
            'tokenable_id' => $user->id,
            'name' => 'token_2',
        ]);
        $this->assertDatabaseHas('personal_access_tokens', [
            'id' => 3,
            'tokenable_type' => 'App\Models\User',
            'tokenable_id' => $user->id,
            'name' => 'token_3',
        ]);

        $user->deleteTokens();

        $this->assertDatabaseMissing('personal_access_tokens', [
            'id' => 1,
            'tokenable_type' => 'App\Models\User',
            'tokenable_id' => $user->id,
            'name' => 'token_1',
        ]);
        $this->assertDatabaseMissing('personal_access_tokens', [
            'id' => 2,
            'tokenable_type' => 'App\Models\User',
            'tokenable_id' => $user->id,
            'name' => 'token_2',
        ]);
        $this->assertDatabaseMissing('personal_access_tokens', [
            'id' => 3,
            'tokenable_type' => 'App\Models\User',
            'tokenable_id' => $user->id,
            'name' => 'token_3',
        ]);
    }

    public function testRefreshTokenWithDefaultName()
    {
        $user = User::factory()->create();

        $user->newToken('firstToken');
        $user->newToken('secondToken');

        $this->assertDatabaseHas('personal_access_tokens', [
            'id' => 1,
            'tokenable_type' => 'App\Models\User',
            'tokenable_id' => $user->id,
            'name' => 'firstToken',
        ]);

        $this->assertDatabaseHas('personal_access_tokens', [
            'id' => 2,
            'tokenable_type' => 'App\Models\User',
            'tokenable_id' => $user->id,
            'name' => 'secondToken',
        ]);

        $user->regenerateToken();

        $this->assertDatabaseMissing('personal_access_tokens', [
            'id' => 1,
            'tokenable_type' => 'App\Models\User',
            'tokenable_id' => $user->id,
            'name' => 'firstToken',
        ]);
        $this->assertDatabaseMissing('personal_access_tokens', [
            'id' => 2,
            'tokenable_type' => 'App\Models\User',
            'tokenable_id' => $user->id,
            'name' => 'secondToken',
        ]);
        $this->assertDatabaseHas('personal_access_tokens', [
            'id' => 3,
            'tokenable_type' => 'App\Models\User',
            'tokenable_id' => $user->id,
            'name' => 'frontend',
        ]);
    }

    public function testRefreshTokenWithName()
    {
        $user = User::factory()->create();

        $user->newToken('firstToken');
        $user->newToken('secondToken');

        $this->assertDatabaseHas('personal_access_tokens', [
            'id' => 1,
            'tokenable_type' => 'App\Models\User',
            'tokenable_id' => $user->id,
            'name' => 'firstToken',
        ]);

        $this->assertDatabaseHas('personal_access_tokens', [
            'id' => 2,
            'tokenable_type' => 'App\Models\User',
            'tokenable_id' => $user->id,
            'name' => 'secondToken',
        ]);

        $user->regenerateToken('new_token');

        $this->assertDatabaseMissing('personal_access_tokens', [
            'id' => 1,
            'tokenable_type' => 'App\Models\User',
            'tokenable_id' => $user->id,
            'name' => 'firstToken',
        ]);
        $this->assertDatabaseMissing('personal_access_tokens', [
            'id' => 2,
            'tokenable_type' => 'App\Models\User',
            'tokenable_id' => $user->id,
            'name' => 'secondToken',
        ]);
        $this->assertDatabaseHas('personal_access_tokens', [
            'id' => 3,
            'tokenable_type' => 'App\Models\User',
            'tokenable_id' => $user->id,
            'name' => 'new_token',
        ]);
    }
}