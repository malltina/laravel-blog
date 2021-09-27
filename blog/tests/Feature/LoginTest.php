<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_can_login()
    {
        $userTest = [
            'email' => 'ysnbngn.bgn@gmail.com',
            'password' => '124546590906'
        ];

        $request = $this->post('api/v1/login', $userTest);
        $request->assertStatus(201);
    }
}
