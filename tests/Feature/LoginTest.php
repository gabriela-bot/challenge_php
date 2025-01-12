<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Passport\Client;
use Laravel\Passport\Passport;
use Laravel\Sanctum\Sanctum;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class LoginTest extends TestCase
{

    public function setUp() : void
    {
        parent::setUp();

        $client = Client::factory()->create([
            'personal_access_client' => true
        ]);

        config()->set('passport.personal_access_client.id',$client->id);
        config()->set('passport.personal_access_client.secret',$client->secret);

    }
    public function test_user_can_login_with_valid_credentials(): void
    {

        $user = User::factory()->create();

        $response = $this->postJson('/api/login',
            [
                'email' => $user->email,
                'password' => 'password'
            ]
        );

        $response->assertStatus(200)
        ->assertJsonStructure(['token']);
    }

    public function test_login_fails_with_invalid_credentials(): void
    {
        Client::factory()->create([
            'personal_access_client' => true
        ]);
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
        Client::factory()->create([
            'personal_access_client' => true
        ]);
        $response = $this->postJson('/api/login',[]);

        $response->assertStatus(422)
            ->assertInvalid(['email', 'password']);
    }
}
