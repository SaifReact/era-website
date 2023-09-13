<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ProductManagementTest extends TestCase
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
    public function product_can_be_added()
    {
        $payload = [
            'logo' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'product_name' => 'product_name',
            'summary' => 'summary',
            'url' => 'http://www.example.com',
            'box_color' => '#FFCC00',
            'order' => 1,
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->postJson('/api/admin/products', $payload, $headers);

        $this->assertCount(1, Product::all());
        $response->assertCreated();
    }

    /** @test */
    public function product_can_be_updated()
    {
        $payload = [
            'logo' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'product_name' => 'product_name',
            'summary' => 'summary',
            'url' => 'http://www.example.com',
            'box_color' => '#FFCC00',
            'order' => 1,
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $this->postJson('/api/admin/products', $payload, $headers);

        $product = Product::first();

        $payload1 = [
            'logo' => 'http://laracms.local/cms_assets/25-200x300.jpg',
            'product_name' => 'product_name1',
            'summary' => 'summary1',
            'url' => 'http://www.example1.com',
            'box_color' => '#FFCC11',
            'order' => 2,
        ];

        $response = $this->patchJson("/api/admin/products/$product->id", $payload1, $headers);

        $product1 = Product::first();

        $this->assertEquals('http://laracms.local/cms_assets/25-200x300.jpg', $product1->logo);
        $this->assertEquals('product_name1', $product1->product_name);
        $this->assertEquals('summary1', $product1->summary);
        $this->assertEquals('http://www.example1.com', $product1->url);
        $this->assertEquals('#FFCC11', $product1->box_color);
        $this->assertEquals(2, $product1->order);

        $response->assertOk();
    }

    /** @test */
    public function product_can_be_deleted()
    {
        $payload = [
            'logo' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'product_name' => 'product_name',
            'summary' => 'summary',
            'url' => 'http://www.example.com',
            'box_color' => '#FFCC00',
            'order' => 1,
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $this->postJson('/api/admin/products', $payload, $headers);

        $this->assertCount(1, Product::all());

        $product = Product::first();
        $response = $this->deleteJson("/api/admin/products/$product->id");

        $this->assertCount(0, Product::all());

        $response->assertOk();
    }

    /** @test */
    public function product_can_be_viewed()
    {
        $payload = [
            'logo' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'product_name' => 'product_name',
            'summary' => 'summary',
            'url' => 'http://www.example.com',
            'box_color' => '#FFCC00',
            'order' => 1,
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $this->postJson('/api/admin/products', $payload, $headers);

        $product = Product::first();
        $response = $this->getJson("/api/admin/products/$product->id");

        $this->assertEquals('http://laracms.local/cms_assets/1026-200x300.jpg', $product->logo);
        $this->assertEquals('product_name', $product->product_name);
        $this->assertEquals('summary', $product->summary);
        $this->assertEquals('http://www.example.com', $product->url);
        $this->assertEquals('#FFCC00', $product->box_color);
        $this->assertEquals(1, $product->order);

        $response->assertOk();
    }

    /** @test */
    public function product_can_be_listed()
    {
        $payload = [
            'logo' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'product_name' => 'product_name',
            'summary' => 'summary',
            'url' => 'http://www.example.com',
            'box_color' => '#FFCC00',
            'order' => 1,
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $this->postJson('/api/admin/products', $payload, $headers);

        $this->assertCount(1, Product::all());

        $payload = [
            'logo' => 'http://laracms.local/cms_assets/25-200x300.jpg',
            'product_name' => 'product_name1',
            'summary' => 'summary1',
            'url' => 'http://www.example1.com',
            'box_color' => '#FFCC11',
            'order' => 2,
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $this->postJson('/api/admin/products', $payload, $headers);

        $this->assertCount(2, Product::all());

        $response = $this->getJson('/api/admin/products');

        $response->assertOk();
    }

    public function product_logo_is_required()
    {
        $payload = [
            'logo' => '',
            'product_name' => 'product_name',
            'summary' => 'summary',
            'url' => 'http://www.example.com',
            'box_color' => '#FFCC00',
            'order' => 1,
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->postJson('/api/admin/products', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.logo', [
                'The logo field is required.'
            ]);
    }


    /** @test */
    public function product_logo_should_have_correct_url_format()
    {
        $payload = [
            'logo' => 'email@example1.com',
            'product_name' => 'product_name',
            'summary' => 'summary',
            'url' => 'http://www.example.com',
            'box_color' => '#FFCC00',
            'order' => 1,
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->postJson('/api/admin/products', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.logo', [
                'The logo must be a valid URL.'
            ]);
    }

    /** @test */
    public function product_logo_should_have_minimum_length()
    {
        $payload = [
            'logo' => 'http://www.l',
            'product_name' => 'product_name',
            'summary' => 'summary',
            'url' => 'http://www.example.com',
            'box_color' => '#FFCC00',
            'order' => 1,
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->postJson('/api/admin/products', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.logo', [
                'The logo must be at least 14 characters.'
            ]);
    }

    /** @test */
    public function product_logo_should_have_maximum_length()
    {
        $payload = [
            'logo' => 'http://laracms.local/cms_assets/1026-200x3001026-200x3001026-200x3001026-200x3001026-200x300
            1026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x300
            1026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x300
            1026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x300
            1026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x300
            1026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x300
            1026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x300.jpg',
            'product_name' => 'product_name',
            'summary' => 'summary',
            'url' => 'http://www.example.com',
            'box_color' => '#FFCC00',
            'order' => 1,
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->postJson('/api/admin/products', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.logo', [
                'The logo must be a valid URL.',
                'The logo must not be greater than 191 characters.'
            ]);
    }

    /** @test */
    public function product_product_name_is_required()
    {
        $payload = [
            'logo' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'product_name' => '',
            'summary' => 'summary',
            'url' => 'http://www.example.com',
            'box_color' => '#FFCC00',
            'order' => 1,
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->postJson('/api/admin/products', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.product_name', [
                'The product name field is required.'
            ]);
    }

    /** @test */
    public function product_product_name_should_have_minimum_length()
    {
        $payload = [
            'logo' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'product_name' => 'p',
            'summary' => 'summary',
            'url' => 'http://www.example.com',
            'box_color' => '#FFCC00',
            'order' => 1,
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->postJson('/api/admin/products', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.product_name', [
                'The product name must be at least 3 characters.'
            ]);
    }

    /** @test */
    public function product_product_name_should_have_maximum_length()
    {
        $payload = [
            'logo' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'product_name' => 'product_nameproduct_nameproduct_nameproduct_nameproduct_nameproduct_nameproduct_name
            product_nameproduct_nameproduct_nameproduct_nameproduct_nameproduct_nameproduct_nameproduct_nameproduct_name
            product_nameproduct_nameproduct_nameproduct_nameproduct_nameproduct_nameproduct_nameproduct_nameproduct_name
            product_nameproduct_nameproduct_nameproduct_nameproduct_nameproduct_nameproduct_nameproduct_nameproduct_name
            product_nameproduct_nameproduct_nameproduct_nameproduct_nameproduct_nameproduct_nameproduct_nameproduct_name
            product_nameproduct_nameproduct_nameproduct_nameproduct_nameproduct_nameproduct_nameproduct_nameproduct_name',
            'summary' => 'summary',
            'url' => 'http://www.example.com',
            'box_color' => '#FFCC00',
            'order' => 1,
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->postJson('/api/admin/products', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.product_name', [
                'The product name must not be greater than 100 characters.'
            ]);
    }

    /** @test */
    public function product_summary_is_required()
    {
        $payload = [
            'logo' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'product_name' => 'product_name',
            'summary' => '',
            'url' => 'http://www.example.com',
            'box_color' => '#FFCC00',
            'order' => 1,
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->postJson('/api/admin/products', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.summary', [
                'The summary field is required.'
            ]);
    }

    /** @test */
    public function product_summary_should_have_minimum_length()
    {
        $payload = [
            'logo' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'product_name' => 'product_name',
            'summary' => 's',
            'url' => 'http://www.example.com',
            'box_color' => '#FFCC00',
            'order' => 1,
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->postJson('/api/admin/products', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.summary', [
                'The summary must be at least 3 characters.'
            ]);
    }

    /** @test */
    public function product_summary_should_have_maximum_length()
    {
        $payload = [
            'logo' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'product_name' => 'product_name',
            'summary' => 'summarysummarysummarysummarysummarysummarysummarysummarysummarysummarysummarysummarysummary
            summarysummarysummarysummarysummarysummarysummarysummarysummarysummarysummarysummarysummarysummarysummary
            summarysummarysummarysummarysummarysummarysummarysummarysummarysummarysummarysummarysummarysummarysummary
            summarysummarysummarysummarysummarysummarysummarysummarysummarysummarysummarysummarysummarysummarysummary
            summarysummarysummarysummarysummarysummarysummarysummarysummarysummarysummarysummarysummarysummarysummary
            summarysummarysummarysummarysummarysummarysummarysummarysummarysummarysummarysummarysummarysummarysummary
            summarysummarysummarysummarysummarysummarysummarysummarysummarysummarysummarysummarysummarysummarysummary
            summarysummarysummarysummarysummarysummarysummarysummarysummarysummarysummarysummarysummarysummarysummary
            summarysummarysummarysummarysummarysummarysummarysummarysummarysummarysummarysummarysummarysummarysummary
            summarysummarysummarysummarysummarysummarysummarysummarysummarysummarysummarysummarysummarysummarysummary',
            'url' => 'http://www.example.com',
            'box_color' => '#FFCC00',
            'order' => 1,
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->postJson('/api/admin/products', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.summary', [
                'The summary must not be greater than 1000 characters.'
            ]);
    }

    /** @test */
    public function product_url_should_have_correct_url_format()
    {
        $payload = [
            'logo' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'product_name' => 'product_name',
            'summary' => 'summary',
            'url' => 'root@example.com',
            'box_color' => '#FFCC00',
            'order' => 1,
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->postJson('/api/admin/products', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.url', [
                'The url must be a valid URL.'
            ]);
    }

    /** @test */
    public function product_url_should_have_minimum_length()
    {
        $payload = [
            'logo' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'product_name' => 'product_name',
            'summary' => 'summary',
            'url' => 'http://www.e',
            'box_color' => '#FFCC00',
            'order' => 1,
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->postJson('/api/admin/products', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.url', [
                'The url must be at least 14 characters.'

            ]);
    }

    /** @test */
    public function product_url_should_have_maximum_length()
    {
        $payload = [
            'logo' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'product_name' => 'product_name',
            'summary' => 'summary',
            'url' => 'http://www.exampleexampleexampleexampleexampleexampleexampleexampleexampleexampleexample
            exampleexampleexampleexampleexampleexampleexampleexampleexampleexampleexampleexampleexampleexample
            exampleexampleexampleexampleexampleexampleexampleexampleexampleexampleexampleexampleexampleexample
            exampleexampleexampleexampleexampleexampleexampleexampleexampleexampleexampleexampleexampleexample
            exampleexampleexampleexampleexampleexampleexampleexampleexampleexampleexampleexampleexampleexample
            exampleexampleexampleexampleexampleexampleexampleexampleexampleexampleexampleexampleexampleexample.com',
            'box_color' => '#FFCC00',
            'order' => 1,
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->postJson('/api/admin/products', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.url', [
                'The url must be a valid URL.',
                'The url must not be greater than 200 characters.'
            ]);
    }

    /** @test */
    public function product_box_color_is_required()
    {
        $payload = [
            'logo' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'product_name' => 'product_name',
            'summary' => 'summary',
            'url' => 'http://www.example.com',
            'box_color' => '',
            'order' => 1,
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->postJson('/api/admin/products', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.box_color', [
                'The box color field is required.'
            ]);
    }

    /** @test */
    public function product_box_color_should_have_minimum_length()
    {
        $payload = [
            'logo' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'product_name' => 'product_name',
            'summary' => 'summary',
            'url' => 'http://www.example.com',
            'box_color' => 'FFCC0',
            'order' => 1,
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->postJson('/api/admin/products', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.box_color', [
                'The box color must be at least 7 characters.'
            ]);
    }

    /** @test */
    public function product_box_color_should_have_maximum_length()
    {
        $payload = [
            'logo' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'product_name' => 'product_name',
            'summary' => 'summary',
            'url' => 'http://www.example.com',
            'box_color' => 'rgba(255, 255, 255, 0.1) ABCDEFGH ABCDEFGH',
            'order' => 1,
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->postJson('/api/admin/products', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.box_color', [
                'The box color must not be greater than 40 characters.'
            ]);
    }

    /** @test */
    public function product_order_is_required()
    {
        $payload = [
            'logo' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'product_name' => 'product_name',
            'summary' => 'summary',
            'url' => 'http://www.example.com',
            'box_color' => '#FFCC0',
            'order' => null,
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->postJson('/api/admin/products', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.order', [
                'The order field is required.'
            ]);
    }

    /** @test */
    public function product_order_should_be_integer_type()
    {
        $payload = [
            'logo' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'product_name' => 'product_name',
            'summary' => 'summary',
            'url' => 'http://www.example.com',
            'box_color' => '#FFCC0',
            'order' => 'a',
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->postJson('/api/admin/products', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.order', [
                'The order must be an integer.'
            ]);
    }
}
