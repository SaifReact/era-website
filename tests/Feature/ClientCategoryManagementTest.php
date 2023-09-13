<?php

namespace Tests\Feature;

use App\Models\ClientCategory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ClientCategoryManagementTest extends TestCase
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
    public function client_category_can_be_added()
    {
        $payload = [
            'logo' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'category_name' => 'category_name',
            'slug' => 'category_name',
            'order' => 1,
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->postJson('/api/admin/client-categories', $payload, $headers);

        $this->assertCount(1, ClientCategory::all());

        $response->assertCreated();
    }

    /** @test */
    public function client_category_can_be_updated()
    {
        $this->withoutExceptionHandling();

        $payload = [
            'logo' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'category_name' => 'category_name',
            'slug' => 'category_name',
            'order' => 1,
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $this->postJson('/api/admin/client-categories', $payload, $headers);

        $clientCategory = ClientCategory::first();

        $payload1 = [
            'logo' => 'http://laracms.local/cms_assets/25-200x300.jpg',
            'category_name' => 'category_name1',
            'order' => 2,
        ];

        $response = $this->patchJson("/api/admin/client-categories/{$clientCategory->id}", $payload1, $headers);

        $clientCategory1 = ClientCategory::first();

        $this->assertEquals('http://laracms.local/cms_assets/25-200x300.jpg', $clientCategory1->logo);
        $this->assertEquals('category_name1', $clientCategory1->category_name);
        $this->assertEquals('category-name1', $clientCategory1->slug);
        $this->assertEquals(2, $clientCategory1->order);

        $response->assertOk();
    }

    /** @test */
    public function client_category_can_be_deleted()
    {
        $payload = [
            'logo' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'category_name' => 'category_name',
            'slug' => 'category_name',
            'order' => 1,
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $this->postJson('/api/admin/client-categories', $payload, $headers);

        $this->assertCount(1, ClientCategory::all());

        $clientCategory = ClientCategory::first();
        $response = $this->deleteJson("/api/admin/client-categories/{$clientCategory->id}");

        $this->assertCount(0, ClientCategory::all());

        $response->assertOk();
    }

    /** @test */
    public function client_category_can_be_viewed()
    {
        $payload = [
            'logo' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'category_name' => 'category_name',
            'slug' => 'category_name',
            'order' => 1,
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $this->postJson('/api/admin/client-categories', $payload, $headers);

        $clientCategory = ClientCategory::first();
        $response = $this->getJson("/api/admin/client-categories/{$clientCategory->id}");

        $this->assertEquals('http://laracms.local/cms_assets/1026-200x300.jpg', $clientCategory->logo);
        $this->assertEquals('category_name', $clientCategory->category_name);
        $this->assertEquals('category-name', $clientCategory->slug);
        $this->assertEquals(1, $clientCategory->order);

        $response->assertOk();
    }

    /** @test */
    public function client_category_can_be_listed()
    {
        $payload = [
            'logo' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'category_name' => 'category_name',
            'slug' => 'category_name',
            'order' => 1,
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $this->postJson('/api/admin/client-categories', $payload, $headers);

        $this->assertCount(1, ClientCategory::all());

        $payload1 = [
            'logo' => 'http://laracms.local/cms_assets/25-200x300.jpg',
            'category_name' => 'category_name1',
            'slug' => 'category_name1',
            'order' => 2,
        ];

        $response = $this->postJson('/api/admin/client-categories', $payload1, $headers);

        $this->assertCount(2, ClientCategory::all());

        $response = $this->getJson('/api/admin/client-categories');

        $response->assertOk();
    }

    public function client_category_logo_is_required()
    {
        $payload = [
            'logo' => '',
            'category_name' => 'category_name',
            'slug' => 'category_name',
            'order' => 1,
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->postJson('/api/admin/client-categories', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.logo', [
                'The logo field is required.'
            ]);
    }

    /** @test */
    public function client_category_logo_should_have_correct_url_format()
    {
        $payload = [
            'logo' => 'email@example1.com',
            'category_name' => 'category_name',
            'slug' => 'category_name',
            'order' => 1,
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->postJson('/api/admin/client-categories', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.logo', [
                'The logo must be a valid URL.'
            ]);
    }

    /** @test */
    public function client_category_logo_should_have_minimum_length()
    {
        $payload = [
            'logo' => 'http://l.l',
            'category_name' => 'category_name',
            'slug' => 'category_name',
            'order' => 1,
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->postJson('/api/admin/client-categories', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.logo', [
                'The logo must be at least 14 characters.'
            ]);
    }

    /** @test */
    public function client_category_logo_should_have_maximum_length()
    {
        $payload = [
            'logo' => 'http://laracms.local/cms_assets/1026-200x3001026-200x3001026-200x3001026-200x3001026-200x300
            1026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x300
            1026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x300
            1026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x300
            1026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x300
            1026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x300
            1026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x300.jpg',
            'category_name' => 'category_name',
            'slug' => 'category_name',
            'order' => 1,
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->postJson('/api/admin/client-categories', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.logo', [
                'The logo must be a valid URL.',
                'The logo must not be greater than 191 characters.'
            ]);
    }

    /** @test */
    public function client_category_category_name_is_required()
    {
        $payload = [
            'logo' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'category_name' => '',
            'slug' => 'category_name',
            'order' => 1,
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->postJson('/api/admin/client-categories', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.category_name', [
                'The category name field is required.'
            ]);
    }

    /** @test */
    public function client_category_category_name_should_have_minimum_length()
    {
        $payload = [
            'logo' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'category_name' => 'c',
            'slug' => 'c',
            'order' => 1,
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->postJson('/api/admin/client-categories', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.category_name', [
                'The category name must be at least 3 characters.'
            ]);
    }

    /** @test */
    public function client_category_category_name_should_have_maximum_length()
    {
        $payload = [
            'logo' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'category_name' => 'category_namecategory_namecategory_namecategory_namecategory_namecategory_name
            category_namecategory_namecategory_namecategory_namecategory_namecategory_namecategory_namecategory_name
            category_namecategory_namecategory_namecategory_namecategory_namecategory_namecategory_namecategory_name
            category_namecategory_namecategory_namecategory_namecategory_namecategory_namecategory_namecategory_name
            category_namecategory_namecategory_namecategory_namecategory_namecategory_namecategory_namecategory_name
            category_namecategory_namecategory_namecategory_namecategory_namecategory_namecategory_namecategory_name
            category_namecategory_namecategory_namecategory_namecategory_namecategory_namecategory_namecategory_name
            category_namecategory_namecategory_namecategory_namecategory_namecategory_namecategory_namecategory_name
            category_namecategory_namecategory_namecategory_namecategory_namecategory_namecategory_namecategory_name
            category_namecategory_namecategory_namecategory_namecategory_namecategory_namecategory_namecategory_name',
            'slug' => 'category_namecategory_namecategory_namecategory_namecategory_namecategory_name
            category_namecategory_namecategory_namecategory_namecategory_namecategory_namecategory_namecategory_name
            category_namecategory_namecategory_namecategory_namecategory_namecategory_namecategory_namecategory_name
            category_namecategory_namecategory_namecategory_namecategory_namecategory_namecategory_namecategory_name
            category_namecategory_namecategory_namecategory_namecategory_namecategory_namecategory_namecategory_name
            category_namecategory_namecategory_namecategory_namecategory_namecategory_namecategory_namecategory_name
            category_namecategory_namecategory_namecategory_namecategory_namecategory_namecategory_namecategory_name
            category_namecategory_namecategory_namecategory_namecategory_namecategory_namecategory_namecategory_name
            category_namecategory_namecategory_namecategory_namecategory_namecategory_namecategory_namecategory_name
            category_namecategory_namecategory_namecategory_namecategory_namecategory_namecategory_namecategory_name',
            'order' => 1,
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->postJson('/api/admin/client-categories', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.category_name', [
                'The category name must not be greater than 100 characters.'
            ]);
    }

    /** @test */
    public function client_category_order_is_required()
    {
        $payload = [
            'logo' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'category_name' => 'category_name',
            'slug' => 'category_name',
            'order' => null,
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->postJson('/api/admin/client-categories', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.order', [
                'The order field is required.'
            ]);
    }

    /** @test */
    public function client_category_order_should_be_integer_type()
    {
        $payload = [
            'logo' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'category_name' => 'category_name',
            'slug' => 'category_name',
            'order' => 'a',
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->postJson('/api/admin/client-categories', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.order', [
                'The order must be an integer.'
            ]);
    }


    /** @test */
    public function client_category_slug_should_be_unique()
    {
        $payload = [
            'logo' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'category_name' => 'category_name',
            'slug' => 'category_name',
            'order' => 1,
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $this->postJson('/api/admin/client-categories', $payload, $headers);

        $payload1 = [
            'logo' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'category_name' => 'category_name1',
            'slug' => 'category-name',
            'order' => 2,
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->postJson('/api/admin/client-categories', $payload1, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.slug', [
                'The slug has already been taken.'
            ]);
    }

    /** @test */
    public function client_category_slug_should_have_minimum_length()
    {
        $payload = [
            'logo' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'category_name' => 'c',
            'slug' => 'c',
            'order' => 1,
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->postJson('/api/admin/client-categories', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.slug', [
                'The slug must be at least 3 characters.'
            ]);
    }

    /** @test */
    public function client_category_slug_should_have_maximum_length()
    {
        $payload = [
            'logo' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'category_name' => 'category_namecategory_namecategory_namecategory_namecategory_namecategory_name
            category_namecategory_namecategory_namecategory_namecategory_namecategory_namecategory_namecategory_name
            category_namecategory_namecategory_namecategory_namecategory_namecategory_namecategory_namecategory_name
            category_namecategory_namecategory_namecategory_namecategory_namecategory_namecategory_namecategory_name
            category_namecategory_namecategory_namecategory_namecategory_namecategory_namecategory_namecategory_name
            category_namecategory_namecategory_namecategory_namecategory_namecategory_namecategory_namecategory_name
            category_namecategory_namecategory_namecategory_namecategory_namecategory_namecategory_namecategory_name
            category_namecategory_namecategory_namecategory_namecategory_namecategory_name
            category_namecategory_namecategory_namecategory_namecategory_namecategory_namecategory_namecategory_name
            category_namecategory_namecategory_namecategory_namecategory_namecategory_namecategory_namecategory_name
            category_namecategory_namecategory_namecategory_namecategory_namecategory_namecategory_namecategory_name
            category_namecategory_namecategory_namecategory_namecategory_namecategory_namecategory_namecategory_name
            category_namecategory_namecategory_namecategory_namecategory_namecategory_namecategory_namecategory_name
            category_namecategory_namecategory_namecategory_namecategory_namecategory_namecategory_namecategory_name',
            'slug' => 'category_namecategory_namecategory_namecategory_namecategory_namecategory_name
            category_namecategory_namecategory_namecategory_namecategory_namecategory_namecategory_namecategory_name
            category_namecategory_namecategory_namecategory_namecategory_namecategory_namecategory_namecategory_name
            category_namecategory_namecategory_namecategory_namecategory_namecategory_namecategory_namecategory_name
            category_namecategory_namecategory_namecategory_namecategory_namecategory_namecategory_namecategory_name
            category_namecategory_namecategory_namecategory_namecategory_namecategory_namecategory_namecategory_name
            category_namecategory_namecategory_namecategory_namecategory_namecategory_namecategory_namecategory_name
            category_namecategory_namecategory_namecategory_namecategory_namecategory_name
            category_namecategory_namecategory_namecategory_namecategory_namecategory_namecategory_namecategory_name
            category_namecategory_namecategory_namecategory_namecategory_namecategory_namecategory_namecategory_name
            category_namecategory_namecategory_namecategory_namecategory_namecategory_namecategory_namecategory_name
            category_namecategory_namecategory_namecategory_namecategory_namecategory_namecategory_namecategory_name
            category_namecategory_namecategory_namecategory_namecategory_namecategory_namecategory_namecategory_name
            category_namecategory_namecategory_namecategory_namecategory_namecategory_namecategory_namecategory_name',
            'order' => 1,
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->postJson('/api/admin/client-categories', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.slug', [
                'The slug must not be greater than 150 characters.'
            ]);
    }
}
