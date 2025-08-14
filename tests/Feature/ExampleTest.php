<?php

namespace Tests\Feature;

use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        // Jika langsung OK
        if ($response->status() === 200) {
            $response->assertStatus(200);
        }
        // Jika redirect
        elseif ($response->status() === 302) {
            $response->assertRedirect('/login'); 
        }
        // Jika status code tidak sesuai
        else {
            $this->fail('Unexpected status code: ' . $response->status());
        }
    }
}
