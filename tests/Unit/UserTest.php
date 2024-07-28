<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
//use PHPUnit\Framework\TestCase;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    use RefreshDatabase;

    public function test_register_user()
    {
        $response = $this->postJson('/auth/register', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'Password123!',
            'password_confirmation' => 'Password123!',
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('users', ['email' => 'john@example.com']);
    }

    public function test_login_user()
    {
        $user = User::factory()->create([
            'email' => 'john@example.com',
            'password' => bcrypt('Password123!'),
        ]);

        $response = $this->postJson('/auth/login', [
            'email' => 'john@example.com',
            'password' => 'Password123!',

        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'access_token',
            'token_type',
            'expires_in'
        ]);
    }

    public function test_logout_user()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user, 'api')->postJson('/auth/logout');

        $response->assertStatus(200);
    }
}
