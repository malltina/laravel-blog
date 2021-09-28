<?php

namespace Tests\Feature\Post;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;
use App\Models\Post;

class CreatPostTest extends TestCase
{

    use RefreshDatabase;

    public function test_user_unauthenticated_cannot_created_post()
    {
        $response = $this->postJson(route('posts.store'), [
            'title' => 'test title',
            'body'  => 'test body',
        ]);
        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    public function test_logged_in_user_can_created_post()
    {
        Sanctum::actingAs(User::factory()->create());
        $response = $this->postJson(route('posts.store'), [
            'title' => 'test title',
            'body'  => 'test body',
        ]);
        $response->assertStatus(Response::HTTP_CREATED);
    }

    public function test_create_post_title_validation_work()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $this->post(route('posts.store'), [
            'title' => '',
        ])->assertSessionHasErrors('title');
        $this->post(route('posts.store'), [
            'title' => 123,
        ])->assertSessionHasErrors('title');
        $this->post(route('posts.store'), [
            'title' => 'Test Title',
        ])->assertSessionDoesntHaveErrors('title');
    }

    public function test_create_post_body_validation_work()
    {
        $user = User::factory()->create();
        $post=Post::factory(10)->create(['user_id'=>$user->id]);
        Sanctum::actingAs($user);
        $this->post(route('posts.store'), [
            'body' => '',
        ])->assertSessionHasErrors('body');
        $this->post(route('posts.store'), [
            'body' => 123,
        ])->assertSessionHasErrors('body');
        $this->post(route('posts.store'), [
            'body' => 'Test Body',
        ])->assertSessionDoesntHaveErrors('body');
    }

}
