<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class LoginTest extends TestCase
{
    public function test_user_can_login_with_valid_credentials(): void
    {
        $user = User::factory()->create([
            'password' => Hash::make('password')
        ]);

        $response = $this->postJson('/api/login',
            [
                'email' => $user->email,
                'password' => 'password'
            ]
        );

        $response->assertStatus(200)
        ->assertJsonStructure(['token']);

        $content = $response->getContent();
        $this->assertMatchesRegularExpression('/^\d{1,}(\|)\w*$/',json_decode($content)->token);
    }

    public function test_login_fails_with_invalid_credentials(): void
    {
        $user = User::factory()->create([
            'password' => Hash::make('password')
        ]);

        $response = $this->postJson('/api/login',
            [
                'email' => $user->email,
                'password' => 'clave'
            ]
        );

        $response->assertStatus(404)
            ->assertJsonStructure(['message']);
    }



    public function test_login_requires_email_and_password(): void
    {
        $response = $this->postJson('/api/login',[]);

        $response->assertStatus(422)
            ->assertInvalid(['email', 'password']);
    }
}
