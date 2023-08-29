<?php

namespace Tests\Feature;

use App\Models\Apartment;
use App\Models\Bed;
use App\Models\BedType;
use App\Models\City;
use App\Models\Country;
use App\Models\Geoobject;
use App\Models\Property;
use App\Models\Room;
use App\Models\RoomType;
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

       // dd($response);

        $response->assertStatus(200);
        $response->assertJsonCount(1, 'properties');
        $response->assertJsonFragment(['properties' => ['address' => $propertyInCity->address]]);

    }
/*
    public function test_property_search_by_country_returns_correct_result()
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

        $propertyInCountry = Property::factory()->create(['owner_id' => $owner->id, 'city_id' => $city->id]);
        $response = $this->getJson('/api/search?country=' . $country->id);

        $response->assertStatus(200);
        $response->assertJsonCount(1);
        $response->assertJsonFragment(['id' => $propertyInCountry->id]);
    }

    public function test_property_search_by_geoobject_returns_correct_results(): void
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

        $geoobject = Geoobject::factory()->create(
            [
                'city_id' => $city->id,
                'name' => 'Statue of Liberty',
                'lat' => 40.6892470,
                'long' => -74.0445020,
            ]
        );

        $propertyNear = Property::factory()->create([
            'owner_id' => $owner->id,
            'city_id' => $city->id,
            'lat' => $geoobject->lat,
            'long' => $geoobject->long,
        ]);

        $propertyFar = Property::factory()->create([
            'owner_id' => $owner->id,
            'city_id' => $city->id,
            'lat' => $geoobject->lat + 10,
            'long' => $geoobject->long - 10,
        ]);
        $response = $this->getJson('/api/search?geoobject=' . $geoobject->id);

        $response->assertStatus(200);
        $response->assertJsonCount(1);
        $response->assertJsonFragment(['id' => $propertyNear->id]);
    }

    public function test_property_search_by_capacity_returns_correct_results(): void
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

        $property = Property::factory()->create([
            'owner_id' => $owner->id,
            'city_id' => $city->id,
        ]);

        Apartment::factory()->create([
            'property_id' => $property->id,
            //'name' => 'Бунгало',
            'capacity_adults' => 2,
            'capacity_children' => 2,
        ]);

        $response = $this->getJson('/api/search?city=' . $city->id . '&adults=2&children=1');
        $response->assertStatus(200);
        $response->assertJsonCount(1);
        $response->assertJsonFragment(['id' => $property->id]);
    }
    public function test_property_search_by_capacity_returns_only_suitable_apartments(): void
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

        $property = Property::factory()->create([
            'owner_id' => $owner->id,
            'city_id' => $city->id,
        ]);

        $smallApartment = Apartment::factory()->create([
            'name' => 'Small apartment',
            'property_id' => $property->id,
            'capacity_adults' => 1,
            'capacity_children' => 0,
        ]);
        $largeApartment = Apartment::factory()->create([
            'name' => 'Large apartment',
            'property_id' => $property->id,
            'capacity_adults' => 3,
            'capacity_children' => 2,
        ]);

        $response = $this->getJson('/api/search?city=' . $city->id . '&adults=2&children=1');
        $response->assertStatus(200);
        $response->assertJsonCount(1);
        $response->assertJsonCount(1, '0.apartments');
        $response->assertJsonPath('0.apartments.0.name', $largeApartment->name);
    }

    public function test_property_search_beds_list_all_cases(): void
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

        $property = Property::factory()->create([
            'owner_id' => $owner->id,
            'city_id' => $city->id,
        ]);

        $apartment = Apartment::factory()->create([
            'name' => 'Small apartment',
            'property_id' => $property->id,
            'capacity_adults' => 1,
            'capacity_children' => 0,
        ]);

        // ----------------------
        // FIRST: check that bed list if empty if no beds
        // ----------------------

        $response = $this->getJson('/api/search?city=' . $city->id);

        $response->assertStatus(200);
        $response->assertJsonCount(1);
        $response->assertJsonCount(1, '0.apartments');
        $response->assertJsonPath('0.apartments.0.beds_list', '');

        // ----------------------
        // SECOND: create 1 room with 1 bed
        // ----------------------

        $roomTypeBedroom = RoomType::query()->create([
            'name' => 'Bedroom'
        ]);
        $room = Room::create([
            'apartment_id' => $apartment->id,
            'room_type_id' => $roomTypeBedroom->id,
            'name' => 'Bedroom',
        ]);

        $bedType = BedType::query()->create([
            'name' => 'Single bed'
        ]);

        Bed::create([
            'room_id' => $room->id,
            'bed_type_id' => $bedType->id,
        ]);

        $response = $this->getJson('/api/search?city=' . $city->id);
        $response->assertStatus(200);
        $response->assertJsonPath('0.apartments.0.beds_list', '1 ' . $bedType->name);

        // ----------------------
        // THIRD: add another bed to the same room
        // ----------------------
        Bed::create([
            'room_id' => $room->id,
            'bed_type_id' => $bedType->id,
        ]);

        $response = $this->getJson('/api/search?city=' . $city->id);
        $response->assertStatus(200);
        $response->assertJsonPath('0.apartments.0.beds_list', '2 ' . str($bedType->name)->plural());

        // ----------------------
        // FOURTH: add a second room with no beds
        // ----------------------
        $roomTypeLivingRoom = RoomType::query()->create([
            'name' => 'Living Room'
        ]);
        $secondRoom = Room::create([
            'apartment_id' => $apartment->id,
            'room_type_id' => $roomTypeLivingRoom->id,
            'name' => 'Living room',
        ]);

        $response = $this->getJson('/api/search?city=' . $city->id);
        $response->assertStatus(200);
        $response->assertJsonPath('0.apartments.0.beds_list', '2 ' . str($bedType->name)->plural());

        // ----------------------
        // FIFTH: add one bed to that second room
        // ----------------------
        Bed::create([
            'room_id' => $secondRoom->id,
            'bed_type_id' => $bedType->id,
        ]);

        $response = $this->getJson('/api/search?city=' . $city->id);
        $response->assertStatus(200);
        $response->assertJsonPath('0.apartments.0.beds_list', '3 ' . str($bedType->name)->plural());

        // ----------------------
        // SIXTH: add another bed with a different type to that second room
        // ----------------------

        $bedTypeTwo = BedType::query()->create([
            'name' => 'Large double bed'
        ]);
        Bed::create([
            'room_id' => $secondRoom->id,
            'bed_type_id' => $bedTypeTwo->id,
        ]);

        $response = $this->getJson('/api/search?city=' . $city->id);
        $response->assertStatus(200);

        $response->assertJsonPath('0.apartments.0.beds_list', '4 beds (3 ' . str($bedType->name)->plural() . ', 1 ' . $bedTypeTwo->name . ')');

        // ----------------------
        // SEVENTH: add a second bed with that new type to that second room
        // ----------------------

        Bed::create([
            'room_id' => $secondRoom->id,
            'bed_type_id' => $bedTypeTwo->id,
        ]);

        $response = $this->getJson('/api/search?city=' . $city->id);
        $response->assertStatus(200);
        $response->assertJsonPath('0.apartments.0.beds_list', '5 beds (3 ' . str($bedType->name)->plural() . ', 2 ' . str($bedTypeTwo->name)->plural() . ')');
    }

    public function test_property_search_returns_one_best_apartment_per_property()
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

        $property = Property::factory()->create([
            'owner_id' => $owner->id,
            'city_id' => $city->id,
        ]);

        $largeApartment = Apartment::factory()->create([
            'name' => 'Large apartment',
            'property_id' => $property->id,
            'capacity_adults' => 3,
            'capacity_children' => 2,
        ]);
        $midSizeApartment = Apartment::factory()->create([
            'name' => 'Mid size apartment',
            'property_id' => $property->id,
            'capacity_adults' => 2,
            'capacity_children' => 1,
        ]);
        $smallApartment = Apartment::factory()->create([
            'name' => 'Small apartment',
            'property_id' => $property->id,
            'capacity_adults' => 1,
            'capacity_children' => 0,
        ]);

        $response = $this->getJson('/api/search?city=' . $city->id . '&adults=2&children=1');
        $response->assertStatus(200);
        $response->assertJsonCount(1, '0.apartments');
        $response->assertJsonPath('0.apartments.0.name', $midSizeApartment->name);

    }*/
}
