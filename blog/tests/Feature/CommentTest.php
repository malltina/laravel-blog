<?php

namespace Tests\Feature;

use App\Models\Comment;
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
        $comment = Comment::factory()->raw(['post_id'=>$post->id]);
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
        $comment = Comment::factory(3)->create(['post_id'=>$post->id]);
        $response = $this->actingAs($user)
            ->getJson(route('posts.comment.show',$post));
        $response->assertJsonCount(3);
        $this->assertDatabaseCount('comments',3);
    }

    /**
     * @test
     */
    public function body_is_required_for_creating_comment()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create(['user_id'=>$user->id]);
        $comment = Comment::factory()->raw(['body'=>null,'post_id'=>$post->id]);
        $this->actingAs($user)
            ->postJson(route('posts.comment.store', ['post' => $post]), $comment);
        $this->assertDatabaseMissing('comments',$comment);
    }
}
