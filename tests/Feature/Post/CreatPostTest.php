<?php

namespace Tests\Feature\Post;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class CreatPostTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_unauthenticated_can_created_post()
    {
        $response = $this->postJson(route('posts.store'), [
            'title' => 'test title',
            'body' => 'test body'
        ]);
        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }
    public function test_logged_in_user_can_created_post()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $response = $this->postJson(route('posts.store'), [
            'title' => 'test title',
            'body' => 'test body'
        ]);
        $response->assertStatus(Response::HTTP_CREATED);
    }

    public function test_create_post_title_validation_work()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $this->post(route('posts.store'), [
            'title' => ''
        ])->assertSessionHasErrors('title');

        $this->post(route('posts.store'), [
            'title' => 123
        ])->assertSessionHasErrors('title');

        $this->post(route('posts.store'), [
            'title' => 'Test Title'
        ])->assertSessionDoesntHaveErrors('title');
    }

}
