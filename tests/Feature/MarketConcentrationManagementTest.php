<?php

namespace Tests\Feature;

use App\Models\MarketConcentration;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

/**
 * Class MarketConcentrationManagementTest
 * @package Tests\Feature
 */
class MarketConcentrationManagementTest extends TestCase
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
    public function market_concentration_can_be_added()
    {
        $payload = [
            'image' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'title' => 'title',
            'order' => 1
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->postJson('/api/admin/market-concentrations', $payload, $headers);

        $response->assertCreated();
        $this->assertCount(1, MarketConcentration::all());

        $response->assertCreated();
    }

    /** @test */
    public function market_concentration_can_be_updated()
    {
        $payload = [
            'image' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'title' => 'title',
            'order' => 1
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $this->postJson('/api/admin/market-concentrations', $payload, $headers);

        $marketConcentration = MarketConcentration::first();

        $response = $this->patchJson("/api/admin/market-concentrations/{$marketConcentration->id}", [
            'image' => 'http://laracms.local/cms_assets/25-200x300.jpg',
            'title' => 'title1',
            'order' => 2
        ]);

        $marketConcentration1 = MarketConcentration::first();

        $this->assertEquals('http://laracms.local/cms_assets/25-200x300.jpg', $marketConcentration1->image);
        $this->assertEquals('title1', $marketConcentration1->title);
        $this->assertEquals(2, $marketConcentration1->order);

        $response->assertOk();
    }

    /** @test */
    public function market_concentration_can_be_deleted()
    {
        $payload = [
            'image' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'title' => 'title',
            'order' => 1
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $this->postJson('/api/admin/market-concentrations', $payload, $headers);

        $marketConcentration = MarketConcentration::first();

        $this->assertCount(1, MarketConcentration::all());

        $response = $this->delete("/api/admin/market-concentrations/{$marketConcentration->id}");

        $this->assertCount(0, MarketConcentration::all());

        $response->assertOk();
    }

    /** @test */
    public function market_concentration_can_be_viewed()
    {
        $payload = [
            'image' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'title' => 'title',
            'order' => 1
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $this->postJson('/api/admin/market-concentrations', $payload, $headers);

        $marketConcentration = MarketConcentration::first();

        $response = $this->getJson("/api/admin/market-concentrations/{$marketConcentration->id}");

        $this->assertEquals('http://laracms.local/cms_assets/1026-200x300.jpg', $marketConcentration->image);
        $this->assertEquals('title', $marketConcentration->title);
        $this->assertEquals(1, $marketConcentration->order);

        $response->assertOk();
    }

    /** @test */
    public function market_concentration_can_be_listed()
    {
        $payload = [
            'image' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'title' => 'title',
            'order' => 1
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $this->postJson('/api/admin/market-concentrations', $payload, $headers);

        $this->assertCount(1, MarketConcentration::all());

        $payload1 = [
            'image' => 'http://laracms.local/cms_assets/25-200x300.jpg',
            'title' => 'title1',
            'order' => 2
        ];

        $this->postJson('/api/admin/market-concentrations', $payload1, $headers);

        $payload = [];
        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->getJson('/api/admin/market-concentrations');

        $this->assertCount(2, MarketConcentration::all());

        $response->assertOk();
    }

    /** @test */
    public function market_concentration_image_is_required()
    {
        $payload = [
            'image' => '',
            'title' => 'title',
            'order' => 1
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->postJson('/api/admin/market-concentrations', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.image', [
                'The image field is required.'
            ]);
    }

    /** @test */
    public function market_concentration_image_should_have_correct_url_format()
    {
        $payload = [
            'image' => 'email@example1.com',
            'title' => 'title',
            'order' => 1
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->postJson('/api/admin/market-concentrations', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.image', [
                'The image must be a valid URL.'
            ]);
    }

    /** @test */
    public function market_concentration_image_should_have_minimum_length()
    {
        $payload = [
            'image' => 'http://www.l',
            'title' => 'title',
            'order' => 1
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->postJson('/api/admin/market-concentrations', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.image', [
                'The image must be at least 14 characters.'
            ]);
    }

    /** @test */
    public function market_concentration_image_should_have_maximum_length()
    {
        $payload = [
            'image' => 'http://laracms.local/cms_assets/25-200x30025-200x30025-200x30025-200x30025-200x30025-200x300
            25-200x30025-200x30025-200x30025-200x30025-200x30025-200x30025-200x30025-200x30025-200x30025-200x300
            25-200x30025-200x30025-200x30025-200x30025-200x30025-200x30025-200x30025-200x30025-200x30025-200x300
            25-200x30025-200x30025-200x30025-200x30025-200x30025-200x30025-200x30025-200x30025-200x30025-200x300
            25-200x30025-200x30025-200x30025-200x30025-200x30025-200x30025-200x30025-200x30025-200x30025-200x300
            25-200x30025-200x30025-200x30025-200x30025-200x30025-200x30025-200x30025-200x30025-200x30025-200x300
            25-200x30025-200x30025-200x30025-200x30025-200x30025-200x30025-200x30025-200x30025-200x30025-200x300
            25-200x30025-200x30025-200x30025-200x30025-200x30025-200x30025-200x30025-200x30025-200x30025-200x300
            25-200x30025-200x30025-200x30025-200x30025-200x30025-200x30025-200x30025-200x30025-200x30025-200x300
            25-200x30025-200x30025-200x30025-200x30025-200x30025-200x30025-200x30025-200x30025-200x30025-200x300
            25-200x30025-200x30025-200x30025-200x30025-200x30025-200x30025-200x30025-200x30025-200x30025-200x300.jpg',
            'title' => 'title',
            'order' => 1
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->postJson('/api/admin/market-concentrations', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.image', [
                'The image must be a valid URL.',
                'The image must not be greater than 191 characters.'
            ]);
    }

    /** @test */
    public function market_concentration_title_is_required()
    {
        $payload = [
            'image' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'title' => '',
            'order' => 1
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->postJson('/api/admin/market-concentrations', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.title', [
                'The title field is required.'
            ]);
    }

    /** @test */
    public function market_concentration_title_should_have_minimum_length()
    {
        $payload = [
            'image' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'title' => 't',
            'order' => 1
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->postJson('/api/admin/market-concentrations', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.title', [
                'The title must be at least 3 characters.'
            ]);
    }

    /** @test */
    public function market_concentration_title_should_have_maximum_length()
    {
        $payload = [
            'image' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'title' => 'titletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitle
            titletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitle
            titletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitle
            titletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitle
            titletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitle
            titletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitle
            titletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitle
            titletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitle
            titletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitle
            titletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitle
            titletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitle
            titletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitle',
            'order' => 1
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->postJson('/api/admin/market-concentrations', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.title', [
                'The title must not be greater than 100 characters.'
            ]);
    }

    /** @test */
    public function market_concentration_order_is_required()
    {
        $payload = [
            'image' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'title' => 'title',
            'order' => null
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->postJson('/api/admin/market-concentrations', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.order', [
                'The order field is required.'
            ]);
    }

    /** @test */
    public function market_concentration_order_should_be_integer_type()
    {
        $payload = [
            'image' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'title' => 'title',
            'order' => 'a'
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->postJson('/api/admin/market-concentrations', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.order', [
                'The order must be an integer.'
            ]);
    }
}
