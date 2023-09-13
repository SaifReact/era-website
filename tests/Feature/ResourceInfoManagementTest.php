<?php

namespace Tests\Feature;

use App\Models\ResourceInfo;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

/**
 * Class ResourceInfoManagementTest
 * @package Tests\Feature
 */
class ResourceInfoManagementTest extends TestCase
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

    public function resource_info_can_be_added()
    {
        $payload = [
            'commencement' => 1,
            'number_of_installation' => 1,
            'customers' => 1,
            'team_members' => 1
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->postJson('/api/admin/resource-infos', $payload, $headers);

        $this->assertCount(1, ResourceInfo::all());
        $response->assertCreated();
    }

    /** @test */
    public function resource_info_can_be_updated()
    {
        $headers = [
            'Accept' => 'application/json'
        ];

        $payload1 = [
            'commencement' => 2,
            'number_of_installation' => 2,
            'customers' => 2,
            'team_members' => 2
        ];

        $response = $this->patchJson("/api/admin/resource-infos", $payload1, $headers);

        $resourceInfo1 = ResourceInfo::first();

        $this->assertEquals(2, $resourceInfo1->commencement);
        $this->assertEquals(2, $resourceInfo1->number_of_installation);
        $this->assertEquals(2, $resourceInfo1->customers);
        $this->assertEquals(2, $resourceInfo1->team_members);

        $response->assertOk();
    }

    public function resource_info_can_be_deleted()
    {
        $payload = [
            'commencement' => 1,
            'number_of_installation' => 1,
            'customers' => 1,
            'team_members' => 1
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $this->postJson('/api/admin/resource-infos', $payload, $headers);

        $this->assertCount(1, ResourceInfo::all());

        $resourceInfo = ResourceInfo::first();

        $response = $this->deleteJson("/api/admin/resource-infos/{$resourceInfo->id}");

        $this->assertCount(0, ResourceInfo::all());

        $response->assertOk();
    }

    /** @test */
    public function resource_info_can_be_viewed()
    {
        $payload = [
            'commencement' => 1,
            'number_of_installation' => 1,
            'customers' => 1,
            'team_members' => 1
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $this->patchJson("/api/admin/resource-infos", $payload, $headers);

        $response = $this->getJson("/api/admin/resource-infos/", $headers);

        $resourceInfo = ResourceInfo::first();

        $this->assertEquals(1, $resourceInfo->commencement);
        $this->assertEquals(1, $resourceInfo->number_of_installation);
        $this->assertEquals(1, $resourceInfo->customers);
        $this->assertEquals(1, $resourceInfo->team_members);

        $response->assertOk();
    }

    public function resource_info_can_be_listed()
    {
        $payload = [
            'commencement' => 1,
            'number_of_installation' => 1,
            'customers' => 1,
            'team_members' => 1
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $this->postJson('/api/admin/resource-infos', $payload, $headers);

        $payload1 = [
            'commencement' => 2,
            'number_of_installation' => 2,
            'customers' => 2,
            'team_members' => 2
        ];

        $this->postJson('/api/admin/resource-infos', $payload1, $headers);

        $response = $this->getJson('/api/admin/resource-infos');
        $this->assertCount(2, ResourceInfo::all());

        $response->assertOk();
    }

    /** @test */
    public function resource_info_commencement_is_required()
    {
        $payload = [
            'commencement' => '',
            'number_of_installation' => 1,
            'customers' => 1,
            'team_members' => 1
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->patchJson('/api/admin/resource-infos', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.commencement', [
                'The commencement field is required.'
            ]);
    }

    /** @test */
    public function resource_info_commencement_should_have_minimum_length()
    {
        $payload = [
            'commencement' => -1,
            'number_of_installation' => 1,
            'customers' => 1,
            'team_members' => 1
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->patchJson('/api/admin/resource-infos', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.commencement', [
                'The commencement must be at least 0.'
            ]);
    }

    /** @test */
    public function resource_info_commencement_should_have_maximum_length()
    {
        $payload = [
            'commencement' => 100001,
            'number_of_installation' => 1,
            'customers' => 1,
            'team_members' => 1
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->patchJson('/api/admin/resource-infos', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.commencement', [
                'The commencement must not be greater than 100000.'
            ]);
    }

    /** @test */
    public function resource_info_number_of_installation_is_required()
    {
        $payload = [
            'commencement' => 1,
            'number_of_installation' => '',
            'customers' => 1,
            'team_members' => 1
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->patchJson('/api/admin/resource-infos', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.number_of_installation', [
                'The number of installation field is required.'
            ]);
    }

    /** @test */
    public function resource_info_number_of_installation_should_have_minimum_length()
    {
        $payload = [
            'commencement' => 1,
            'number_of_installation' => -1,
            'customers' => 1,
            'team_members' => 1
        ];


        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->patchJson('/api/admin/resource-infos', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.number_of_installation', [
                'The number of installation must be at least 0.'
            ]);
    }

    /** @test */
    public function resource_info_number_of_installation_should_have_maximum_length()
    {
        $payload = [
            'commencement' => 1,
            'number_of_installation' => 100001,
            'customers' => 1,
            'team_members' => 1
        ];


        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->patchJson('/api/admin/resource-infos', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.number_of_installation', [
                'The number of installation must not be greater than 100000.'
            ]);
    }

    /** @test */
    public function resource_info_customers_is_required()
    {
        $payload = [
            'commencement' => 1,
            'number_of_installation' => 1,
            'customers' => '',
            'team_members' => 1
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->patchJson('/api/admin/resource-infos', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.customers', [
                'The customers field is required.'
            ]);
    }

    /** @test */
    public function resource_info_customers_should_have_minimum_length()
    {
        $payload = [
            'commencement' => 1,
            'number_of_installation' => 1,
            'customers' => -1,
            'team_members' => 1
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->patchJson('/api/admin/resource-infos', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.customers', [
                'The customers must be at least 0.'
            ]);
    }

    /** @test */
    public function resource_info_customers_should_have_maximum_length()
    {
        $payload = [
            'commencement' => 1,
            'number_of_installation' => 1,
            'customers' => 100001,
            'team_members' => 1
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->patchJson('/api/admin/resource-infos', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.customers', [
                'The customers must not be greater than 100000.'
            ]);
    }

    /** @test */
    public function resource_info_team_members_should_be_integer_type()
    {
        $payload = [
            'commencement' => 1,
            'number_of_installation' => 1,
            'customers' => 1,
            'team_members' => 'a'
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->patchJson('/api/admin/resource-infos', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.team_members', [
                'The team members must be an integer.'
            ]);
    }

    /** @test */
    public function resource_info_team_members_should_have_minimum_length()
    {
        $payload = [
            'commencement' => 1,
            'number_of_installation' => 1,
            'customers' => 1,
            'team_members' => -1
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->patchJson('/api/admin/resource-infos', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.team_members', [
                'The team members must be at least 0.'
            ]);
    }

    /** @test */
    public function resource_info_team_members_should_have_maximum_length()
    {
        $payload = [
            'commencement' => 1,
            'number_of_installation' => 1,
            'customers' => 1,
            'team_members' => 100001
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->patchJson('/api/admin/resource-infos', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.team_members', [
                'The team members must not be greater than 100000.'
            ]);
    }
}
