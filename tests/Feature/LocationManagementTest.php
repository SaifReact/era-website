<?php

namespace Tests\Feature;

use App\Models\Location;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class LocationManagementTest extends TestCase
{
    use RefreshDatabase;

    public function setup(): void
    {
        parent::setUp();

        Sanctum::actingAs(
            User::factory()->create(),
            ['*']
        );
    }

    public function location_can_be_added()
    {
        $this->withoutExceptionHandling();

        $payload = [
            'location_name' => 'location_name',
            'address' => 'address',
            'map_location' => 'https://www.google.com',
            'lat' => 23.7302612,
            'lng' => 90.4064502
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->postJson('/api/admin/locations', $payload, $headers);

        $this->assertCount(1, Location::all());

        $response->assertCreated();
    }

    /** @test */
    public function location_can_be_updated()
    {
        $payload = [
            'location_name' => 'location_name',
            'address' => 'address',
            'map_location' => 'https://www.google.com',
            'lat' => 23.7302612,
            'lng' => 90.4064502
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $this->patchJson('/api/admin/locations', $payload, $headers);

        $location = Location::first();

        $payload1 = [
            'location_name' => 'location_name1',
            'address' => 'address1',
            'map_location' => 'https://www.google1.com',
            'lat' => 24.7302612,
            'lng' => 91.4064502
        ];

        $response = $this->patchJson("/api/admin/locations", $payload1, $headers);

        $location1 = Location::first();

        $this->assertEquals('location_name1', $location1->location_name);
        $this->assertEquals('address1', $location1->address);
        $this->assertEquals('https://www.google1.com', $location1->map_location);
        $this->assertEquals(24.7302612, $location1->lat);
        $this->assertEquals(91.4064502, $location1->lng);

        $response->assertOk();
    }

    public function location_can_be_deleted()
    {
        $this->withoutExceptionHandling();

        $payload = [
            'location_name' => 'location_name',
            'address' => 'address',
            'map_location' => 'https://www.google.com',
            'lat' => 23.7302612,
            'lng' => 90.4064502
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $this->postJson('/api/admin/locations', $payload, $headers);

        $this->assertCount(1, Location::all());
        $location = Location::first();

        $response = $this->deleteJson("/api/admin/locations/{$location->id}");
        $this->assertCount(0, Location::all());
        $response->assertOk();
    }

    /** @test */
    public function location_can_be_viewed()
    {
        $payload = [
            'location_name' => 'location_name',
            'address' => 'address',
            'map_location' => 'https://www.google.com',
            'lat' => 23.7302612,
            'lng' => 90.4064502
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $this->patchJson('/api/admin/locations', $payload, $headers);

        $location = Location::first();
        $response = $this->getJson("/api/admin/locations");

        $this->assertEquals('location_name', $location->location_name);
        $this->assertEquals('address', $location->address);
        $this->assertEquals('https://www.google.com', $location->map_location);
        $this->assertEquals(23.7302612, $location->lat);
        $this->assertEquals(90.4064502, $location->lng);

        $response->assertOk();
    }


    public function location_can_be_listed()
    {
        $this->withoutExceptionHandling();

        $payload = [
            'location_name' => 'location_name',
            'address' => 'address',
            'map_location' => 'https://www.google.com',
            'lat' => 23.7302612,
            'lng' => 90.4064502
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $this->postJson('/api/admin/locations', $payload, $headers);

        $this->assertCount(1, Location::all());

        $payload1 = [
            'location_name' => 'location_name1',
            'address' => 'address1',
            'map_location' => 'https://www.google.com',
            'lat' => 24.7302612,
            'lng' => 91.4064502
        ];


        $this->postJson('/api/admin/locations', $payload1, $headers);

        $response = $this->getJson('/api/admin/locations');

        $this->assertCount(2, Location::all());

        $response->assertOk();
    }
}
