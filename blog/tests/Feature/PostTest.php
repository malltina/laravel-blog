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
        $post = Post::factory(3)->create();
        $this->getJson(route('posts.index'))
             ->assertUnauthorized();
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
        // $attributes = Post::factory()->raw(['body'=>null]);
        $response = $this->actingAs($user)->postJson(route('posts.store'), $attributes);
        $attributes['user_id'] = auth()->user()->id;
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
}
