<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Passport\Passport;
use Tests\TestCase;

class IndexTest extends TestCase
{
    use WithFaker;
    public function test_authenticated_user_can_view_resource_list(): void
    {
        Passport::actingAs(
            User::factory()->create()
        );

        $stringQuery = $this->faker()->word;

        $response = $this->getJson("/api/gifs?q=$stringQuery&limit=10&offset=0");

        $response->assertStatus(200)
            ->assertJsonStructure(['data']);
    }


    public function test_authenticated_user_invalid_parameters(): void
    {
        Passport::actingAs(
            User::factory()->create()
        );

        $response = $this->getJson("/api/gifs");

        $response->assertStatus(422)
            ->assertInvalid(['q']);
    }

    public function test_authenticated_user_invalid_credentials_api(): void
    {
        Passport::actingAs(
            User::factory()->create()
        );

        $stringQuery = $this->faker()->word;

        config()->set('giphy.api_key',' ');

        $response = $this->getJson("/api/gifs?q=$stringQuery");

        $response->assertStatus(401)
            ->assertJson(['message' => 'Unauthorized']);
    }


    public function test_authenticated_user_invalid_credentials_base_url(): void
    {

        Passport::actingAs(
            User::factory()->create()
        );

        $stringQuery = $this->faker()->word;

        config()->set('giphy.base_url',' ');

        $response = $this->getJson("/api/gifs?q=$stringQuery");

        $response->assertStatus(500)
            ->assertJsonStructure(['message']);
    }

    public function test_unauthenticated_user_cannot_access_resource_list(): void
    {
        $response = $this->getJson('/api/gifs');

        $response->assertStatus(401)
            ->assertJson(['message' => 'Unauthenticated.']);
    }
}
