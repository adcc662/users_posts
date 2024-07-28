<?php

namespace Tests\Unit;

use App\Models\Post;
use App\Models\User;
use PHPUnit\Framework\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PostTest extends TestCase
{
    /**
     * A basic unit test example.
     */

    use RefreshDatabase;

    public function test_create_post()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user, 'api')->postJson('/posts', [
            'title' => 'Sample Post',
            'body' => 'This is a sample post.',
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('posts', ['title' => 'Sample Post']);
    }

    public function test_get_post()
    {
        $user = User::factory()->create();
        Post::factory()->count(3)->create(['user_id' => $user->id]);

        $response = $this->actingAs($user, 'api')->getJson('/posts');

        $response->assertStatus(200);
        $response->assertJsonCount(3);
    }

    public function test_update_post()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user, 'api')->putJson("/posts/{$post->id}", [
            'title' => 'Updated Post',
            'body' => 'This is an updated post.',
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('posts', ['title' => 'Updated Post']);
    }

    public function test_delete_post()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user, 'api')->deleteJson("/posts/{$post->id}");

        $response->assertStatus(200);
        $this->assertDeleted($post);
    }






}
