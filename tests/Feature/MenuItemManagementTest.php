<?php

namespace Tests\Feature;

use App\Models\MenuItem;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

/**
 * Class MenuItemManagementTest
 * @package Tests\Feature
 */
class MenuItemManagementTest extends TestCase
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
    public function menu_item_can_be_added()
    {
        $payload = [
            'name' => 'name',
            'menu_id' => 1,
            'page_id' => 1,
            'external_url' => 'https://www.example.com',
            'target' => '_self'
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->postJson('/api/admin/menu-items', $payload, $headers);

        $response->assertCreated();
    }

    /** @test */
    public function menu_item_can_be_updated()
    {
        $payload = [
            'name' => 'name',
            'menu_id' => 1,
            'page_id' => 1,
            'external_url' => 'https://www.example.com',
            'target' => '_self'
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $this->postJson('/api/admin/menu-items', $payload, $headers);

        $menuItem = MenuItem::first();

        $payload1 = [
            'name' => 'name1',
            'menu_id' => 2,
            'page_id' => 2,
            'external_url' => 'https://www.example1.com',
            'target' => '_self'
        ];

        $response = $this->patchJson("/api/admin/menu-items/{$menuItem->id}", $payload1, $headers);

        $menuItem1 = MenuItem::first();

        $this->assertEquals('name1', $menuItem1->name);
        $this->assertEquals(2, $menuItem1->menu_id);
        $this->assertEquals(2, $menuItem1->page_id);
        $this->assertEquals('https://www.example1.com', $menuItem1->external_url);
        $this->assertEquals('_self', $menuItem1->target);

        $response->assertOk();
    }

    /** @test */
    public function menu_item_can_be_deleted()
    {
        $payload = [
            'name' => 'name',
            'menu_id' => 1,
            'page_id' => 1,
            'external_url' => 'https://www.example.com',
            'target' => '_self'
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $this->postJson('/api/admin/menu-items', $payload, $headers);

        $this->assertCount(1, MenuItem::all());
        $menuItem = MenuItem::first();

        $response = $this->delete("/api/admin/menu-items/{$menuItem->id}");
        $this->assertCount(0, MenuItem::all());

        $response->assertOk();
    }

    /** @test */
    public function menu_item_can_be_listed()
    {
        $payload = [
            'name' => 'name',
            'menu_id' => 1,
            'page_id' => 1,
            'external_url' => 'https://www.example.com',
            'target' => '_self'
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $this->postJson('/api/admin/menu-items', $payload, $headers);

        $payload1 = [
            'name' => 'name1',
            'menu_id' => 2,
            'page_id' => 2,
            'external_url' => 'https://www.example1.com',
            'target' => '_self'
        ];

        $this->postJson('/api/admin/menu-items', $payload1, $headers);

        $response = $this->get('/api/admin/menu-items');

        $response->assertOk();
    }

    /** @test */
    public function menu_item_name_is_required()
    {
        $payload = [
            'name' => '',
            'menu_id' => 1,
            'page_id' => 1,
            'external_url' => 'https://www.example.com',
            'target' => '_self'
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->postJson('/api/admin/menu-items', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.name', [
                'The name field is required.'
            ]);
    }

    /** @test */
    public function menu_item_name_should_have_minimum_length()
    {
        $payload = [
            'name' => 'n',
            'menu_id' => 1,
            'page_id' => 1,
            'external_url' => 'https://www.example.com',
            'target' => '_self'
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->postJson('/api/admin/menu-items', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.name', [
                'The name must be at least 3 characters.'
            ]);
    }

    /** @test */
    public function menu_item_name_should_have_maximum_length()
    {
        $payload = [
            'name' => 'namenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamename
            namenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamename
            namenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamename
            namenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamename
            namenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamename
            namenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamename',
            'menu_id' => 1,
            'page_id' => 1,
            'external_url' => 'https://www.example.com',
            'target' => '_self'
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->postJson('/api/admin/menu-items', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.name', [
                'The name must not be greater than 100 characters.'
            ]);
    }

    /** @test */
    public function menu_item_menu_id_is_required()
    {
        $payload = [
            'name' => 'name',
            'menu_id' => null,
            'page_id' => 1,
            'external_url' => 'https://www.example.com',
            'target' => '_self'
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->postJson('/api/admin/menu-items', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.menu_id', [
                'The menu id field is required.'
            ]);
    }

    /** @test */
    public function menu_item_menu_id_should_be_integer_type()
    {
        $payload = [
            'name' => 'name',
            'menu_id' => 'a',
            'page_id' => 1,
            'external_url' => 'https://www.example.com',
            'target' => '_self'
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->postJson('/api/admin/menu-items', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.menu_id', [
                'The menu id must be an integer.'
            ]);
    }

    /** @test */
    public function menu_item_page_id_should_be_integer_type()
    {
        $payload = [
            'name' => 'name',
            'menu_id' => 1,
            'page_id' => 'a',
            'external_url' => 'https://www.example.com',
            'target' => '_self'
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->postJson('/api/admin/menu-items', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.page_id', [
                'The page id must be an integer.'
            ]);
    }

    /** @test */
    public function menu_item_external_url_should_have_correct_url_format()
    {
        $payload = [
            'name' => 'name',
            'menu_id' => 1,
            'page_id' => 1,
            'external_url' => 'root@example.com',
            'target' => '_self'
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->postJson('/api/admin/menu-items', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.external_url', [
                'The external url must be a valid URL.',
            ]);
    }

    /** @test */
    public function menu_item_external_url_should_have_minimum_length()
    {
        $payload = [
            'name' => 'name',
            'menu_id' => 1,
            'page_id' => 1,
            'external_url' => 'http://www.e',
            'target' => '_self'
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->postJson('/api/admin/menu-items', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.external_url', [
                'The external url must be at least 14 characters.'
            ]);
    }

    /** @test */
    public function menu_item_external_url_should_have_maximum_length()
    {
        $payload = [
            'name' => 'name',
            'menu_id' => 1,
            'page_id' => 1,
            'external_url' => 'http://www.exampleexampleexampleexampleexampleexampleexampleexampleexampleexample
            exampleexampleexampleexampleexampleexampleexampleexampleexampleexampleexampleexampleexampleexample
            exampleexampleexampleexampleexampleexampleexampleexampleexampleexampleexampleexampleexampleexample
            exampleexampleexampleexampleexampleexampleexampleexampleexampleexampleexampleexampleexampleexample
            exampleexampleexampleexampleexampleexampleexampleexampleexampleexampleexampleexampleexampleexample.com',
            'target' => '_self'
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->postJson('/api/admin/menu-items', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.external_url', [
                'The external url must be a valid URL.',
                'The external url must not be greater than 150 characters.'
            ]);
    }

    /** @test */
    public function menu_item_target_is_required()
    {
        $payload = [
            'name' => 'name',
            'menu_id' => 1,
            'page_id' => 1,
            'external_url' => 'https://www.example.com',
            'target' => ''
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->postJson('/api/admin/menu-items', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.target', [
                'The target field is required.'
            ]);
    }

    /** @test */
    public function menu_item_target_should_have_minimum_length()
    {
        $payload = [
            'name' => 'name',
            'menu_id' => 1,
            'page_id' => 1,
            'external_url' => 'http://www.example.com',
            'target' => '_'
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->postJson('/api/admin/menu-items', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.target', [
                'The target must be at least 3 characters.'
            ]);
    }

    /** @test */
    public function menu_item_target_should_have_maximum_length()
    {
        $payload = [
            'name' => 'name',
            'menu_id' => 1,
            'page_id' => 1,
            'external_url' => 'http://www.example.com',
            'target' => '_self_self_self_self_self_self_self_self_self_self_self_self_self_self_self_self_self_self
            _self_self_self_self_self_self_self_self_self_self_self_self_self_self_self_self_self_self_self_self_self
            _self_self_self_self_self_self_self_self_self_self_self_self_self_self_self_self_self_self_self_self_self
            _self_self_self_self_self_self_self_self_self_self_self_self_self_self_self_self_self_self_self_self_self
            _self_self_self_self_self_self_self_self_self_self_self_self_self_self_self_self_self_self_self_self_self
            _self_self_self_self_self_self_self_self_self_self_self_self_self_self_self_self_self_self_self_self_self'
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->postJson('/api/admin/menu-items', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.target', [
                'The target must not be greater than 15 characters.'
            ]);
    }
}
