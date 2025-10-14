<?php

namespace Tests\Feature;

<<<<<<< HEAD
use Illuminate\Foundation\Testing\RefreshDatabase;
=======
// use Illuminate\Foundation\Testing\RefreshDatabase;
>>>>>>> df8fd1e0a75bf37a3f73aca1da97278d268a4c67
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
<<<<<<< HEAD
     *
     * @return void
     */
    public function testBasicTest()
=======
     */
    public function test_the_application_returns_a_successful_response(): void
>>>>>>> df8fd1e0a75bf37a3f73aca1da97278d268a4c67
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
