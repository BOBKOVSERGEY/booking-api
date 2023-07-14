<?php

namespace Tests\Feature;

use App\Models\City;
use App\Models\Country;
use App\Models\Property;
use App\Models\User;
use Database\Factories\CityFactory;
use Database\Factories\CountryFactory;
use Database\Factories\PropertyFactory;
use Database\Seeders\PermissionSeeder;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PropertySearchTest extends TestCase
{
    use RefreshDatabase;

  public function test_property_search_by_city_returns_correct_results(): void
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

        $propertyInCity = Property::factory()->create(['owner_id' => $owner->id, 'city_id' => $city->id]);
        $response = $this->getJson('/api/search?city=' . $city->id);

        $response->assertStatus(200);
        $response->assertJsonCount(1);
        $response->assertJsonFragment(['id' => $propertyInCity->id]);


    }
}
