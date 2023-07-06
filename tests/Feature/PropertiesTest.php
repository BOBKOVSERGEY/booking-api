<?php

namespace Tests\Feature;

use App\Models\City;
use App\Models\Country;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PropertiesTest extends TestCase
{
    //use RefreshDatabase;

    /*public function test_property_owner_has_access_to_properties_feature(): void
    {

        $owner = User::factory()
            ->create([
                'role_id' => Role::ROLE_OWNER
            ]);

        $response = $this->actingAs($owner)
            ->getJson('/api/v1/owner/properties');

        $response->assertStatus(200);
    }

    public function test_user_does_not_have_access_to_properties_feature()
    {
        $owner = User::factory()->create(['role_id' => Role::ROLE_USER]);
        $response = $this->actingAs($owner)->getJson('/api/v1/owner/properties');

        $response->assertStatus(403);
    }*/

    /*public function test_property_owner_can_add_property()
    {
        $role = Role::factory()->create();
        $owner = User::factory()->create(['role_id' => $role->id]);
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
    }*/
}
