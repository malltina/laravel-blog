<?php

namespace Tests\Feature;

use App\Models\Comment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Post;
use App\Models\User;


class CommentTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;
    /**
     * A basic feature test example.
     *
     * @return void
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
}
