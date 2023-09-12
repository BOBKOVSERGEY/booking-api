<?php

namespace Tests\Feature;

use App\Models\City;
use App\Models\Country;
use App\Models\Property;
use App\Models\Role;
use App\Models\User;
use Database\Seeders\PermissionSeeder;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PropertiesTest extends TestCase
{
    use RefreshDatabase;

    public function test_property_owner_has_access_to_properties_feature(): void
    {

        $this->seed(RoleSeeder::class);
        $this->seed(PermissionSeeder::class);
        $owner = User::factory()->create();
        $owner->assignRole('Property Owner');

        $response = $this->actingAs($owner)
            ->getJson('/api/v1/owner/properties');

        $response->assertStatus(200);
    }

    public function test_user_does_not_have_access_to_properties_feature()
    {
        $this->seed(RoleSeeder::class);
        $this->seed(PermissionSeeder::class);
        $owner = User::factory()->create();
        $owner->assignRole('Simple User');
        $response = $this->actingAs($owner)->getJson('/api/v1/owner/properties');

        $response->assertStatus(403);
    }

  public function test_property_owner_can_add_property()
    {
        $this->seed(RoleSeeder::class);
        $this->seed(PermissionSeeder::class);
        $owner = User::factory()->create();
        $owner->assignRole('Property Owner');
        $country = Country::factory()->create(
            [
                'name' => 'United States',
                'lat' => 37.09024,
                'long' => -95.712891
            ]
        );
        $city = City::factory()->create(
            [
                'country_id' => $country->id,
                'name' => 'New York',
                'lat' => 40.712776,
                'long' => -74.005974,
            ]
        );

        $response = $this->actingAs($owner)->postJson($this->url . '/owner/properties', [
            'name' => 'My property',
            'city_id' =>  $city->id,
            'address_street' => 'Street Address 1',
            'address_postcode' => '12345',
        ]);

        $response->assertSuccessful();
        $response->assertJsonFragment(['name' => 'My property']);
    }

    public function test_property_owner_can_add_photo_to_property()
    {
        Storage::fake();

        $owner = User::factory()->create(['role_id' => Role::ROLE_OWNER]);
        $cityId = City::value('id');
        $property = Property::factory()->create([
            'owner_id' => $owner->id,
            'city_id' => $cityId,
        ]);

        $response = $this->actingAs($owner)->postJson('/api/owner/properties/' . $property->id . '/photos', [
            'photo' => UploadedFile::fake()->image('photo.png')
        ]);

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'filename' => config('app.url') . '/storage/1/photo.png',
            'thumbnail' => config('app.url') . '/storage/1/conversions/photo-thumbnail.jpg',
        ]);
    }
}
