<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class LoginTest extends TestCase
{
use RefreshDatabase;

    public function test_user_can_login_with_true_credentials()
    {
        $user = User::factory()->create();

        $response = $this->postJson(route('login'), [
            'email' => $user->email,
            'password' => 'password',
        ]);
        $response->assertStatus(Response::HTTP_CREATED);

    }

    public function test_user_name_validation_work()
    {
        $data = [
            'email' => ''
        ];
        $this->post(route('login'), $data)
            ->assertSessionHasErrors(['email']);
        ;

        $data = [
            'email' => 'example'
        ];
        $this->post(route('login'), $data)
            ->assertSessionHasErrors(['email']);
        ;

        $data = [
            'email' => 'example@gmail.com'
        ];
        $this->post(route('login'), $data)
            ->assertSessionDoesntHaveErrors(['email']);
        ;
    }

    public function test_user_password_validation_work()
    {
        $data = [
            'password' => ''
        ];
        $this->post(route('login'), $data)
            ->assertSessionHasErrors(['password']);
        ;

        $data = [
            'password' => 'as'
        ];
        $this->post(route('login'), $data)
            ->assertSessionHasErrors(['password']);
        ;

        $data = [
            'password' => 2134344
        ];
        $this->post(route('login'), $data)
            ->assertSessionHasErrors(['password']);
        ;

        $data = [
            'password' => 'asdfgh1234'
        ];
        $this->post(route('login'), $data)
            ->assertSessionDoesntHaveErrors(['password']);
        ;
    }
}
