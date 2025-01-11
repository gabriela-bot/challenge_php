<?php

namespace Tests\Feature;

use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ShowTest extends TestCase
{
    protected string $element;

    public function setUp(): void
    {
        parent::setUp();

        $this->element = 'ZqlvCTNHpqrio';

    }
    public function test_can_view_single_resource(): void
    {
        Sanctum::actingAs(
            User::factory()->create(),
        );

        $response = $this->getJson("/api/gif/$this->element");

        $response->assertStatus(200);
    }

    public function test_error_for_nonexistent_resource(): void
    {
        Sanctum::actingAs(
            User::factory()->create(),
        );

        $response = $this->getJson('/api/gif/1');

        $response->assertStatus(404)
            ->assertJson(['message' => 'Not Found']);
    }

    public function test_unauthorized_access_to_resource_fails(): void
    {
        Sanctum::actingAs(
            User::factory()->create(),
        );

        config()->set('giphy.api_key',' ');

        $response = $this->getJson("/api/gif/$this->element");

        $response->assertStatus(401)
            ->assertJson(['message' => 'Unauthorized']);
    }
}
