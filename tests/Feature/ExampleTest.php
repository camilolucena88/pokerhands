<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $response = $this->get('/');

        $response->assertRedirect('/login');
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function userAuthenticated()
    {
        $this->actingAs(factory(User::class)->create());

        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
