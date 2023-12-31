<?php

namespace Tests\Feature;

use App\Models\Role;
use Database\Seeders\DatabaseSeeder;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

  public function test_registration_fails_with_admin_role(): void
    {
        $this->seed(RoleSeeder::class);
        $response = $this->postJson('/api/v1/auth/register', [
            'name' => 'Valid name',
            'email' => 'valid@email.com',
            'password' => 'ValidPassword',
            'password_confirmation' => 'ValidPassword',
            'role' => 'Administrator'
        ]);

        $response->assertStatus(422);
    }

    public function test_registration_succeeds_with_owner_role()
    {
        $this->seed(RoleSeeder::class);
        $response = $this->postJson('/api/v1/auth/register', [
            'name' => 'Valid name',
            'email' => 'valid@email.com',
            'password' => 'ValidPassword',
            'password_confirmation' => 'ValidPassword',
            'role' => 'Property Owner'
        ]);

        $response->assertStatus(200);

    }

    public function test_registration_succeeds_with_user_role()
    {
        $this->seed(RoleSeeder::class);
        $response = $this->postJson('/api/v1/auth/register', [
            'name' => 'Valid name',
            'email' => 'valid@email.com',
            'password' => 'ValidPassword',
            'password_confirmation' => 'ValidPassword',
            'role' => 'Simple User'
        ]);
        $response->assertStatus(200);
    }
}
