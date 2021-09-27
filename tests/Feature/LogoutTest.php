<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\HttpFoundation\Response;

use Tests\TestCase;

class LogoutTest extends TestCase
{
    use RefreshDatabase;
    public function test_logged_in_user_can_logout()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)
            ->postJson(route('logout'));
        $response->assertStatus(Response::HTTP_OK);
    }

}
