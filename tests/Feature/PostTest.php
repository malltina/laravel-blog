<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class PostTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    use RefreshDatabase;
    use WithFaker;

    /** @test */
    public function user_can_see_all_post()
    {
        $user = User::factory()->create();
        Task::factory(3)->create(['author_id' => $user->id]);
        Task::factory(2)->create();
        $response = $this->actingAs($user)
            ->getJson(route('posts.index'))
            ->assertOk();
        $response->assertJsonCount(3);
        $this->assertDatabaseCount('tasks', 5);
    }

    /** @test */
    public function authorized_user_can_create_post()
    {

        $user = User::factory()->create();
        $attributes = Post::factory()->raw();
        $this->actingAs($user)
            ->postJson(route('posts.store'), $attributes)
            ->assertStatus(Response::HTTP_CREATED);
        $attributes['user_id'] = auth()->user()->id;
        $this->assertDatabaseHas('posts', $attributes);
    }
    /** @test */
    public function authorized_user_can_see_all_posts()
    {
        $user = User::factory()->create();
        Post::factory(3)->create();
        Post::factory(2)->create(['user_id' => $user->id]);
        $response = $this->actingAs($user)->getJson(route('posts.index'))->assertOk();
        $response->assertJsonCount(5);
        $this->assertDatabaseCount('posts', 5);
    }
    /** @test */
    public function guest_user_cannot_create_post()
    {
        $attributes = Post::factory()->raw(['author_id' => null]);
        $this->postJson(route('posts.store'), $attributes)
            ->assertUnauthorized();

    }
    /** @test */
    public function user_can_update_post()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $user->id]);
        $updateAttributes = Post::factory()->raw(['user_id' => $user->id]);
        $this->actingAs($user)
            ->patchJson(route('posts.update', $post), $updateAttributes)
            ->assertOk();
        $this->assertDatabaseHas('posts', $updateAttributes);
    }
    /** @test */
    public function user_can_delete_post()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create(['author_id' => $user->id]);
        $this->actingAs($user)
            ->deleteJson(route('posts.destroy', $post))
            ->assertOk();
        $this->assertDatabaseMissing('posts', $user->only('id'));
    }
}
