<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function dataProvider(): array
    {
        return [
            [
                ['body' => 'task body'],
            ],
            [
                ['title' => 'test'],
            ],
        ];
    }

    /** @test */
    public function guest_user_should_not_be_able_to_see_posts()
    {
        Post::factory(3)->create();
        $this->getJson(route('posts.index'))
             ->assertUnauthorized();
    }

    /** @test */
    public function auth_user_can_see_specific_post()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create();//TODO: how can i show specific post
        $this->actingAs($user)->getJson(route('posts.show',$post))->assertOk();
    }

    /** @test */
    public function auth_user_can_see_all_posts()
    {
        $user = User::factory()->create();
        Post::factory(3)->create();
        Post::factory(2)->create(['user_id'=>$user->id]);
        $response = $this->actingAs($user)->getJson(route('posts.index'))->assertOk();
        $response->assertJsonCount(5);
        $this->assertDatabaseCount('posts',5);
    }

    /** @test */
    public function only_auth_user_can_create_post()
    {
        $user = User::factory()->create();
        $attributes = Post::factory()->raw();
        $response = $this->actingAs($user)->postJson(route('posts.store'), $attributes);
        $attributes['user_id'] = auth()->user()->id;
        $this->assertDatabaseHas('posts',$attributes);
    }

    /** 
     * @test
     * @dataProvider dataProvider
     */
    public function title_and_body_is_required_for_creating_post($attributes)
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->postJson(route('posts.store'), $attributes);
        $attributes['user_id'] = $user->id;
        $this->assertDatabaseMissing('posts',$attributes);
        $response->assertUnprocessable();
    }
    
    /** @test */
    public function post_can_updated_by_onwer()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create(['user_id'=>$user->id]);
        $attribute = Post::factory()->raw(['user_id'=>$user->id]);
        $this->actingAs($user)->putJson(route('posts.update',$post), $attribute)->assertOk();
        $this->assertDatabaseHas('posts',$attribute);
    }

    /** @test */
    public function post_can_deleted_by_onwer()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create(['user_id'=>$user->id]);
        $this->actingAs($user)->deleteJson(route('posts.destroy',$post))->assertNoContent();
        $this->assertDatabaseMissing('posts',$post->only('id'));
    }
    
    /** @test */
    public function post_can_not_deleted_by_other_users()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create(['user_id'=>$user->id]);
        $other_user = User::factory()->create();
        $this->actingAs($other_user)->deleteJson(route('posts.destroy',$post))->assertForbidden();
        $this->assertDatabaseHas('posts',$post->only('id'));
    }

    /** @test */
    public function post_can_not_updated_by_other_users()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create(['user_id'=>$user->id]);
        $other_user = User::factory()->create();
        $attribute = Post::factory()->raw(['user_id'=>$other_user->id]);
        
        $this->actingAs($other_user)->putJson(route('posts.update',$post), $attribute)->assertForbidden();
        $this->assertDatabaseHas('posts',$post->only('title'));
    }

}
