<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
  public function test_can_register()
  {
      $userTest = [
          'name' => 'yasinbgn',
          'email' => 'ysnbngn.bgn@gmail.com',
          'password' => '124546590906'
      ];

      $request = $this->post('api/v1/register', $userTest);
      $request->assertStatus(201);

  }
}
