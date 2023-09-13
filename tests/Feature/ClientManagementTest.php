<?php

namespace Tests\Feature;

use App\Models\Client;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ClientManagementTest extends TestCase
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
    public function client_can_be_added()
    {
        $response = $this->postJson('/api/admin/clients', [
            'logo' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'client_category_id' => 1,
            'client_name' => 'client_name',
            'url' => 'http://www.example.com',
            'order' => 1
        ]);

        $this->assertCount(1, Client::all());
        $response->assertCreated();
    }

    /** @test */
    public function client_can_be_updated()
    {
        $this->postJson('/api/admin/clients', [
            'logo' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'client_category_id' => 1,
            'client_name' => 'client_name',
            'url' => 'http://www.example.com',
            'order' => 1
        ]);

        $client = Client::first();

        $response = $this->patchJson("/api/admin/clients/{$client->id}", [
            'logo' => 'http://laracms.local/cms_assets/25-200x300.jpg',
            'client_category_id' => 2,
            'client_name' => 'client_name1',
            'url' => 'http://www.example1.com',
            'order' => 2
        ]);

        $client1 = Client::first();

        $this->assertEquals('http://laracms.local/cms_assets/25-200x300.jpg', $client1->logo);
        $this->assertEquals('client_name1', $client1->client_name);
        $this->assertEquals('http://www.example1.com', $client1->url);
        $this->assertEquals(2, $client1->order);

        $response->assertOk();
    }

    /** @test */
    public function client_can_be_deleted()
    {
        $this->postJson('/api/admin/clients', [
            'logo' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'client_category_id' => 1,
            'client_name' => 'client_name',
            'url' => 'http://www.example.com',
            'order' => 1
        ]);

        $this->assertCount(1, Client::all());
        $client = Client::first();

        $response = $this->deleteJson("/api/admin/clients/{$client->id}");

        $this->assertCount(0, Client::all());
        $response->assertOk();
    }

    /** @test */
    public function client_can_be_viewed()
    {
        $this->postJson('/api/admin/clients', [
            'logo' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'client_category_id' => 1,
            'client_name' => 'client_name',
            'url' => 'http://www.example.com',
            'order' => 1
        ]);

        $client = Client::first();

        $response = $this->getJson("/api/admin/clients/{$client->id}");

        $this->assertEquals('http://laracms.local/cms_assets/1026-200x300.jpg', $client->logo);
        $this->assertEquals('client_name', $client->client_name);
        $this->assertEquals('http://www.example.com', $client->url);
        $this->assertEquals(1, $client->order);

        $response->assertOk();
    }

    /** @test */
    public function client_can_be_listed()
    {
        $this->postJson('/api/admin/clients', [
            'logo' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'client_category_id' => 1,
            'client_name' => 'client_name',
            'url' => 'http://www.example.com',
            'order' => 1
        ]);

        $this->assertCount(1, Client::all());

        $this->postJson('/api/admin/clients', [
            'logo' => 'http://laracms.local/cms_assets/25-200x300.jpg',
            'client_category_id' => 2,
            'client_name' => 'client_name1',
            'url' => 'http://www.example1.com',
            'order' => 2
        ]);

        $this->assertCount(2, Client::all());

        $response = $this->getJson('/api/admin/clients');

        $response->assertOk();
    }

    /** @test */
    public function client_logo_is_required()
    {
        $response = $this->postJson('/api/admin/clients', [
            'logo' => '',
            'client_category_id' => 1,
            'client_name' => 'client_name1',
            'url' => 'http://www.example1.com',
            'order' => 2
        ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.logo', ['The logo field is required.']);
    }

    /** @test */
    public function client_logo_should_have_correct_url_format()
    {
        $payload = [
            'logo' => 'email@example1.com',
            'client_category_id' => 1,
            'client_name' => 'client_name',
            'url' => 'http://www.example.com',
            'order' => 1
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->postJson('/api/admin/clients', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.logo', [
                'The logo must be a valid URL.'
            ]);
    }

    /** @test */
    public function client_logo_should_have_minimum_length()
    {
        $payload = [
            'logo' => 'http://l.l',
            'client_category_id' => 1,
            'client_name' => 'client_name',
            'url' => 'http://www.example.com',
            'order' => 1
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->postJson('/api/admin/clients', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.logo', [
                'The logo must be at least 14 characters.'
            ]);
    }

    /** @test */
    public function client_logo_should_have_maximum_length()
    {
        $payload = [
            'logo' => 'http://laracms.local/cms_assets/1026-200x3001026-200x3001026-200x3001026-200x3001026-200x300
            1026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x300
            1026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x300
            1026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x300
            1026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x300
            1026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x300
            1026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x300.jpg',
            'client_category_id' => 1,
            'client_name' => 'client_name',
            'url' => 'http://www.example.com',
            'order' => 1
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->postJson('/api/admin/clients', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.logo', [
                'The logo must be a valid URL.',
                'The logo must not be greater than 191 characters.'
            ]);
    }

    /** @test */
    public function client_client_name_is_required()
    {
        $response = $this->postJson('/api/admin/clients', [
            'logo' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'client_category_id' => 1,
            'client_name' => '',
            'url' => 'http://www.example.com',
            'order' => 1
        ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.client_name', [
                'The client name field is required.'
            ]);
    }

    /** @test */
    public function client_client_name_should_have_minimum_length()
    {
        $response = $this->postJson('/api/admin/clients', [
            'logo' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'client_category_id' => 1,
            'client_name' => 'c',
            'url' => 'http://www.example.com',
            'order' => 1
        ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.client_name', [
                'The client name must be at least 3 characters.'
            ]);
    }

    /** @test */
    public function client_client_name_should_have_maximum_length()
    {
        $response = $this->postJson('/api/admin/clients', [
            'logo' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'client_category_id' => 1,
            'client_name' => 'client_nameclient_nameclient_nameclient_nameclient_nameclient_nameclient_nameclient_name
            client_nameclient_nameclient_nameclient_nameclient_nameclient_nameclient_nameclient_nameclient_name
            client_nameclient_nameclient_nameclient_nameclient_nameclient_nameclient_nameclient_nameclient_name
            client_nameclient_nameclient_nameclient_nameclient_nameclient_nameclient_nameclient_nameclient_name
            client_nameclient_nameclient_nameclient_nameclient_nameclient_nameclient_nameclient_nameclient_name
            client_nameclient_nameclient_nameclient_nameclient_nameclient_nameclient_nameclient_nameclient_name
            client_nameclient_nameclient_nameclient_nameclient_nameclient_nameclient_nameclient_nameclient_name
            client_nameclient_nameclient_nameclient_nameclient_nameclient_nameclient_nameclient_nameclient_name',
            'url' => 'http://www.example.com',
            'order' => 1
        ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.client_name', [
                'The client name must not be greater than 100 characters.'
            ]);
    }

    /** @test */
    public function client_url_should_have_correct_url_format()
    {
        $response = $this->postJson('/api/admin/clients', [
            'logo' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'client_category_id' => 1,
            'client_name' => 'client_name',
            'url' => 'root@example.com',
            'order' => 1
        ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.url', [
                'The url must be a valid URL.'
            ]);
    }

    /** @test */
    public function client_url_should_have_minimum_length()
    {
        $response = $this->postJson('/api/admin/clients', [
            'logo' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'client_category_id' => 1,
            'client_name' => 'client_name',
            'url' => 'http://www.e',
            'order' => 1
        ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.url', [
                'The url must be at least 14 characters.'
            ]);
    }

    /** @test */
    public function client_url_should_have_maximum_length()
    {
        $response = $this->postJson('/api/admin/clients', [
            'logo' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'client_category_id' => 1,
            'client_name' => 'client_name',
            'url' => 'www.example1example1example1example1example1example1example1example1example1example1example1
            example1example1example1example1example1example1example1example1example1example1example1example1
            example1example1example1example1example1example1example1example1example1example1example1example1
            example1example1example1example1example1example1example1example1example1example1example1example1
            example1example1example1example1example1example1example1example1example1example1example1example1
            example1example1example1example1example1example1example1example1example1example1example1example1
            example1example1example1example1example1example1example1example1example1example1example1example1
            example1example1example1example1example1example1example1example1example1example1example1example1
            example1example1example1example1example1example1example1example1example1example1example1example1
            example1example1example1example1example1example1example1example1example1example1example1example1
            example1example1example1example1example1example1example1example1example1example1example1example1
            example1example1example1example1example1example1example1example1example1example1example1example1.com',
            'order' => 1
        ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.url', [
                'The url must be a valid URL.',
                'The url must not be greater than 200 characters.'
            ]);
    }

    /** @test */
    public function client_order_is_required()
    {
        $response = $this->postJson('/api/admin/banners', [
            'logo' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'client_category_id' => 1,
            'client_name' => 'client_name',
            'url' => 'http://www.example.com',
            'order' => null
        ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.order', [
                'The order field is required.'
            ]);
    }

    /** @test */
    public function client_order_should_be_integer_type()
    {
        $response = $this->postJson('/api/admin/banners', [
            'logo' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'client_category_id' => 1,
            'client_name' => 'client_name',
            'url' => 'http://www.example.com',
            'order' => 'a'
        ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.order', [
                'The order must be an integer.'
            ]);
    }
}
