<?php

namespace Tests\Feature\Post;

use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
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

}
