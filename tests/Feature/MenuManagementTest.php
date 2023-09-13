<?php

namespace Tests\Feature;

use App\Models\Menu;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

/**
 * Class MenuManagementTest
 * @package Tests\Feature
 */
class MenuManagementTest extends TestCase
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

    /** @test */
    public function menu_can_be_added()
    {
        $payload = [
            'name' => 'name',
            'order' => 1
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->postJson('/api/admin/menus', $payload, $headers);

        $response->assertCreated();
    }

    /** @test */
    public function menu_can_be_updated()
    {
        $payload = [
            'name' => 'name',
            'order' => 1
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $this->postJson('/api/admin/menus', $payload, $headers);

        $menu = Menu::first();

        $payload1 = [
            'name' => 'name1',
            'order' => 2
        ];

        $response = $this->patchJson("/api/admin/menus/{$menu->id}", $payload1, $headers);

        $menu1 = Menu::first();

        $this->assertEquals('name1', $menu1->name);
        $this->assertEquals(2, $menu1->order);

        $response->assertOk();
    }

    /** @test */
    public function menu_can_be_deleted()
    {
        $payload = [
            'name' => 'name',
            'order' => 1
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $this->postJson('/api/admin/menus', $payload, $headers);

        $this->assertCount(3, Menu::all());
        $menu = Menu::first();
        $response = $this->deleteJson("/api/admin/menus/{$menu->id}");
        $this->assertCount(2, Menu::all());
        $response->assertOk();
    }

    /** @test */
    public function menu_can_be_viewed()
    {
        $payload = [
            'name' => 'name',
            'order' => 1
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $this->postJson('/api/admin/menus', $payload, $headers);

        $menu = Menu::orderBy('id', 'DESC')->first();
        $response = $this->getJson("/api/admin/menus/{$menu->id}");

        $this->assertEquals('name', $menu->name);
        $this->assertEquals(1, $menu->order);

        $response->assertOk();
    }

    /** @test */
    public function menu_can_be_listed()
    {
        $payload = [
            'name' => 'name',
            'order' => 1
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $this->postJson('/api/admin/menus', $payload, $headers);

        $payload1 = [
            'name' => 'name1',
            'order' => 2
        ];

        $this->postJson('/api/admin/menus', $payload1, $headers);

        $response = $this->getJson('/api/admin/menus');

        $response->assertOk();
    }

    /** @test */
    public function menu_name_is_required()
    {
        $payload = [
            'name' => '',
            'order' => 1
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->postJson('/api/admin/menus', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.name', [
                'The name field is required.'
            ]);
    }

    /** @test */
    public function menu_name_should_be_unique()
    {
        $payload = [
            'name' => 'name',
            'order' => 1
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $this->postJson('/api/admin/menus', $payload, $headers);

        $payload1 = [
            'name' => 'name',
            'order' => 2
        ];

        $response = $this->postJson('/api/admin/menus', $payload1, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.name', [
                'The name has already been taken.'
            ]);
    }

    /** @test */
    public function menu_name_should_have_minimum_length()
    {
        $payload = [
            'name' => 'n',
            'order' => 1
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->postJson('/api/admin/menus', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.name', [
                'The name must be at least 2 characters.'
            ]);
    }

    /** @test */
    public function menu_name_should_have_maximum_length()
    {
        $payload = [
            'name' => 'namenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamename
            namenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamename
            namenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamename
            namenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamename
            namenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamename
            namenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamename
            namenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamename
            namenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamename
            namenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamename
            namenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamename',
            'order' => 1
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->postJson('/api/admin/menus', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.name', [
                'The name must not be greater than 50 characters.'
            ]);
    }

    /** @test */
    public function menu_order_is_required()
    {
        $payload = [
            'name' => 'name',
            'order' => null
        ];

        $headers = [
            'Accept' => 'application/json'
        ];
        $response = $this->postJson('/api/admin/menus', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.order', [
                'The order field is required.'
            ]);
    }

    /** @test */
    public function menu_order_should_be_integer_type()
    {
        $payload = [
            'name' => 'name',
            'order' => 'a'
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->postJson('/api/admin/menus', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.order', [
                'The order must be an integer.'
            ]);
    }
}
