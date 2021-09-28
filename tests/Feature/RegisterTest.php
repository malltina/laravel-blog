<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterTest extends TestCase
{

    use RefreshDatabase;

    public function test_user_can_register()
    {
        $attributes = User::factory()
                          ->unverified()
                          ->withoutRememerToken()
                          ->raw([
                              'name'                  => 'Andrew Laskevych',
                              'email'                 => 'test@gmail.com',
                              'password'              => 'secret_pass',
                              'password_confirmation' => 'secret_pass',
                          ]);
        $this->postJson(route('register'), $attributes);
        $this->assertDatabaseHas('users', [
            'email' => $attributes['email'],
        ]);
    }

    public function test_register_name_validation_work()
    {
        $data = [
            'name' => '',
        ];
        $this->postJson(route('register'), $data)
             ->assertUnprocessable()
             ->assertJsonValidationErrors('name');
        $data = [
            'name' => 1234567,
        ];
        $this->postJson(route('register'), $data)
             ->assertUnprocessable()
             ->assertJsonValidationErrors('name');
        $data = [
            'name' => 'Aram',
        ];
        $this->postJson(route('register'), $data)
             ->assertJsonMissingValidationErrors('name');;
    }

    public function test_register_email_validation_work()
    {
        $data = [
            'email' => '',
        ];
        $this->post(route('register'), $data)
             ->assertSessionHasErrors(['email']);;
        $data = [
            'email' => 'fdsdssds',
        ];
        $this->post(route('register'), $data)
             ->assertSessionHasErrors(['email']);;
        $user = User::factory()->create();
        $data = [
            'email' => $user->email,
        ];
        $this->post(route('register'), $data)
             ->assertSessionHasErrors(['email']);;
        $data = [
            'email' => 'aram@gmail.com',
        ];
        $this->post(route('register'), $data)
             ->assertSessionDoesntHaveErrors(['email']);;
    }

    public function test_register_password_validation_work()
    {
        $data = [
            'password' => '',
        ];
        $this->post(route('register'), $data)
             ->assertSessionHasErrors(['password']);;
        $data = [
            'password' => '1',
        ];
        $this->post(route('register'), $data)
             ->assertSessionHasErrors(['password']);;
        $data = [
            'password' => 'Aram0000',
        ];
        $this->post(route('register'), $data)
             ->assertSessionHasErrors(['password']);;
        $data = [
            'password'              => 'Aram0000',
            'password_confirmation' => 'Aram0000',
        ];
        $this->post(route('register'), $data)
             ->assertSessionDoesntHaveErrors(['password']);;
    }

}
