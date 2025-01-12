<?php

namespace Tests\Feature;

use App\Models\Favorite;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
//use Laravel\Sanctum\Sanctum;
use Laravel\Passport\Passport;
use Tests\TestCase;

class FavoriteTest extends TestCase
{
    protected string $element;

    public function setUp(): void
    {
        parent::setUp();

        $this->element = 'ZqlvCTNHpqrio';

    }

    public function test_can_create_resource_with_valid_data(): void
    {

        $user = User::factory()->create();

        Passport::actingAs(
            $user
        );

        $response = $this->postJson('/api/add-favorite',[
            'gif_id' => $this->element,
            'alias' => 'funny',
            'user_id' => $user->id
        ]);

        $response->assertStatus(204);
    }

    public function test_cannot_create_resource_with_invalid_data(): void
    {

        $user = User::factory()->create();

        Passport::actingAs(
            $user
        );

        $responseInvalidGif = $this->postJson('/api/add-favorite',[
            'gif_id' => '1',
            'alias' => 'funny',
            'user_id' => $user->id
        ]);

        $responseInvalidGif->assertStatus(422)
            ->assertInvalid(['gif_id']);

        $responseWithoutAlias = $this->postJson('/api/add-favorite',[
            'gif_id' => $this->element,
            'user_id' => $user->id
        ]);

        $responseWithoutAlias->assertStatus(422)
            ->assertInvalid(['alias']);

    }

    public function test_cannot_create_resource_already_exist(): void
    {

        $user = User::factory()->create();

        Passport::actingAs(
            $user
        );

        Favorite::create([
            'gif_id' => $this->element,
            'alias' => 'funny',
            'user_id' => $user->id
        ]);

        $response = $this->postJson('/api/add-favorite',[
            'gif_id' => $this->element,
            'alias' => 'funny',
            'user_id' => $user->id
        ]);

        $response->assertStatus(409)
            ->assertJson(['message' => 'Favorite already exists']);

    }

    public function test_unauthenticated_user_cannot_create_resource(): void
    {

        $user = User::factory()->create();

        Passport::actingAs(
            $user
        );

        $response = $this->postJson('/api/add-favorite',[
            'gif_id' => $this->element,
            'alias' => 'funny',
            'user_id' => 1000
        ]);

        $response->assertStatus(422)
            ->assertInvalid(['user_id']);
    }
}
