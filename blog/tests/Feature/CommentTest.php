<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function auth_user_can_create_comment_for_every_post()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create(['user_id'=>$user->id]);
        $comment = [
            'body' => 'this is body for comment',
            'post_id' => $post->id
        ];
        $this->actingAs($user)
            ->postJson(route('posts.comment.store', ['post' => $post]), $comment);
        $this->assertDatabaseHas('comments',$comment);
    }

    /**
     * @test
     */
    public function auth_user_can_see_all_comment_for_every_post()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create(['user_id'=>$user->id]);
        $comment = [
            'body' => 'this is body for comment',
            'post_id' => $post->id
        ];
        $this->actingAs($user)
            ->postJson(route('posts.comment.store', ['post' => $post]), $comment);
        $this->assertDatabaseHas('comments',$comment);
    }

}
