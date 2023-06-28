<?php

namespace Tests\Feature;

use App\Models\Role;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_fails_with_admin_role(): void
    {
        Role::factory()
            ->create([
                'name' => 'Administrator'
            ]);
        //$this->seed(RoleSeeder::class);

        //$admin = Role::query()->where('name', '=', 'Administrator')->first();

        $response = $this->postJson('/api/v1/auth/register', [
            'name' => 'Valid name',
            'email' => 'valid@email.com',
            'password' => 'ValidPassword',
            'password_confirmation' => 'ValidPassword',
            'role_id' => Role::ROLE_ADMINISTRATOR
        ]);

        $response->assertStatus(422);
    }

    public function test_registration_succeeds_with_owner_role()
    {
        Role::factory()
            ->create([
                'name' => 'Property Owner'
            ]);

        $response = $this->postJson('/api/v1/auth/register', [
            'name' => 'Valid name',
            'email' => 'valid@email.com',
            'password' => 'ValidPassword',
            'password_confirmation' => 'ValidPassword',
            'role_id' => Role::ROLE_OWNER
        ]);

        $response->assertStatus(200);

    }

    public function test_registration_succeeds_with_user_role()
    {
        Role::factory()
            ->create([
                'name' => 'Simple User'
            ]);

        $response = $this->postJson('/api/v1/auth/register', [
            'name' => 'Valid name',
            'email' => 'valid@email.com',
            'password' => 'ValidPassword',
            'password_confirmation' => 'ValidPassword',
            'role_id' => Role::ROLE_USER
        ]);

        $response->assertStatus(200);
    }

}
