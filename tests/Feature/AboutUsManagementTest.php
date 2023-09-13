<?php

namespace Tests\Feature;

use App\Models\AboutUs;
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
 * Class AboutUsManagementTest
 * @package Tests\Feature
 */
class AboutUsManagementTest extends TestCase
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

    public function about_us_can_be_added()
    {
        $payload = [
            'image' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'title' => 'title',
            'summary' => 'summary',
            'url' => 'http://www.example.com',
        ];

        $headers = [
            'Accept' => 'application/json',
        ];

        $response = $this->postJson('/api/admin/about-us', $payload, $headers);

        $response->assertCreated();
        $this->assertCount(1, AboutUs::all());
    }

    /** @test */
    public function about_us_can_be_updated()
    {
        $headers = [
            'Accept' => 'application/json',
        ];

        $payload1 = [
            'image' => 'http://laracms.local/cms_assets/25-200x300.jpg',
            'title' => 'title1',
            'summary' => 'summary1',
            'url' => 'http://www.example1.com',
        ];

        $response = $this->patchJson("/api/admin/about-us", $payload1, $headers);

        $aboutUs1 = AboutUs::first();

        $response->assertOk();

        $this->assertEquals('http://laracms.local/cms_assets/25-200x300.jpg', $aboutUs1->image);
        $this->assertEquals('title1', $aboutUs1->title);
        $this->assertEquals('summary1', $aboutUs1->summary);
        $this->assertEquals('http://www.example1.com', $aboutUs1->url);
    }

    public function about_us_can_be_deleted()
    {
        $payload = [
            'image' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'title' => 'title',
            'summary' => 'summary',
            'url' => 'http://www.example.com',
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $this->postJson('/api/admin/about-us', $payload, $headers);

        $this->assertCount(1, AboutUs::all());
        $aboutUs = AboutUs::first();

        $response = $this->deleteJson("/api/admin/about-us/{$aboutUs->id}", $headers);
        $this->assertCount(0, AboutUs::all());

        $response->assertOk();
    }

    /** @test */
    public function about_us_can_be_viewed()
    {
        $headers = [
            'Accept' => 'application/json'
        ];

        $payload1 = [
            'image' => 'http://laracms.local/cms_assets/25-200x300.jpg',
            'title' => 'title',
            'summary' => 'summary',
            'url' => 'http://www.example.com',
        ];

        $this->patchJson("/api/admin/about-us", $payload1, $headers);

        $response = $this->getJson("/api/admin/about-us", $headers);

        $aboutUs = AboutUs::first();

        $this->assertEquals('http://laracms.local/cms_assets/25-200x300.jpg', $aboutUs->image);
        $this->assertEquals('title', $aboutUs->title);
        $this->assertEquals('summary', $aboutUs->summary);
        $this->assertEquals('http://www.example.com', $aboutUs->url);

        $response->assertOk();
    }

    public function about_us_can_be_listed()
    {
        $payload = [
            'image' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'title' => 'title',
            'summary' => 'summary',
            'url' => 'http://www.example.com',
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $this->postJson('/api/admin/about-us', $payload, $headers);

        $this->assertCount(1, AboutUs::all());

        $payload = [
            'image' => 'http://laracms.local/cms_assets/25-200x300.jpg',
            'title' => 'title1',
            'summary' => 'summary1',
            'url' => 'http://www.example1.com',
        ];

        $this->postJson('/api/admin/about-us', $payload, $headers);

        $this->assertCount(2, AboutUs::all());

        $response = $this->getJson('/api/admin/about-us');

        $response->assertOk();
    }

    /** @test */
    public function about_us_image_is_required()
    {
        $payload = [
            'image' => '',
            'title' => 'title',
            'summary' => 'summary',
            'url' => 'http://www.example.com',
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->patchJson('/api/admin/about-us', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
                ->assertJsonPath('errors.image', ['The image field is required.']);

    }

    /** @test */
    public function about_us_image_should_have_correct_url_format()
    {
        $payload = [
            'image' => 'email@example1.com',
            'title' => 'title',
            'summary' => 'summary',
            'url' => 'http://www.example.com',
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->patchJson('/api/admin/about-us', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.image', [
                'The image must be a valid URL.'
            ]);
    }

    /** @test */
    public function about_us_image_should_have_minimum_length()
    {
        $payload = [
            'image' => 'http://l.l',
            'title' => 'title',
            'summary' => 'summary',
            'url' => 'http://www.example.com',
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->patchJson('/api/admin/about-us', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.image', [
                'The image must be at least 14 characters.'
            ]);
    }

    /** @test */
    public function about_us_image_should_have_maximum_length()
    {
        $payload = [
            'image' => 'http://laracms.local/cms_assets/1026-200x3001026-200x3001026-200x3001026-200x3001026-200x300
            1026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x300
            1026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x300
            1026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x300
            1026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x300
            1026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x300
            1026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x300
            1026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x300.jpg',
            'title' => 'title',
            'summary' => 'summary',
            'url' => 'http://www.example.com',
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->patchJson('/api/admin/about-us', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.image', [
                'The image must be a valid URL.',
                'The image must not be greater than 191 characters.'
            ]);
    }

    /** @test */
    public function about_us_title_is_required()
    {
        $payload = [
            'image' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'title' => '',
            'summary' => 'summary',
            'url' => 'http://www.example.com',
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->patchJson('/api/admin/about-us',$payload , $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.title', ['The title field is required.']);
    }

    /** @test */
    public function about_us_title_should_have_minimum_length()
    {
        $payload = [
            'image' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'title' => 't',
            'summary' => 'summary',
            'url' => 'http://www.example.com',
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->patchJson('/api/admin/about-us', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.title', ['The title must be at least 3 characters.']);
    }

    /** @test */
    public function about_us_title_should_have_maximum_length()
    {
        $payload = [
            'image' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'title' => 'titletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitle
            titletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitle
            titletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitle
            titletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitle
            titletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitle
            titletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitle
            titletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitle
            titletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitle
            titletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitle
            titletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitle
            titletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitle
            titletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitle',
            'summary' => 'summary',
            'url' => 'http://www.example.com',
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->patchJson('/api/admin/about-us', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.title', ['The title must not be greater than 100 characters.']);
    }

    /** @test */
    public function about_us_summary_is_required()
    {
        $payload = [
            'image' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'title' => 'title',
            'summary' => '',
            'url' => 'http://www.example.com',
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->patchJson('/api/admin/about-us', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.summary', ['The summary field is required.']);
    }

    /** @test */
    public function about_us_summary_should_have_minimum_length()
    {
        $payload = [
            'image' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'title' => 'title',
            'summary' => 's',
            'url' => 'http://www.example.com',
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->patchJson('/api/admin/about-us', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.summary', ['The summary must be at least 3 characters.']);
    }

    /** @test */
    public function about_us_summary_should_have_maximum_length()
    {
        $payload = [
            'image' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'title' => 'title',
            'summary' => 'summarysummarysummarysummarysummarysummarysummarysummarysummarysummarysummarysummarysummary
            summarysummarysummarysummarysummarysummarysummarysummarysummarysummarysummarysummarysummarysummarysummary
            summarysummarysummarysummarysummarysummarysummarysummarysummarysummarysummarysummarysummarysummarysummary
            summarysummarysummarysummarysummarysummarysummarysummarysummarysummarysummarysummarysummarysummarysummary
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
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->patchJson('/api/admin/about-us', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.summary', ['The summary must not be greater than 1000 characters.']);
    }

    /** @test */
    public function about_us_url_should_have_correct_url_format()
    {
        $payload = [
            'image' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'title' => 'title',
            'summary' => 'summary',
            'url' => 'root@example.com',
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->patchJson('/api/admin/about-us', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.url', ['The url must be a valid URL.']);
    }

    /** @test */
    public function about_us_url_should_have_minimum_length()
    {
        $payload = [
            'image' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'title' => 'title',
            'summary' => 'summary',
            'url' => 'http://www.e',
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->patchJson('/api/admin/about-us', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.url', [
                'The url must be at least 14 characters.'
            ]);
    }

    /** @test */
    public function about_us_url_should_have_maximum_length()
    {
        $payload = [
            'image' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'title' => 'title',
            'summary' => 'summary',
            'url' => 'http://www.exampleexampleexampleexampleexampleexampleexampleexampleexampleexampleexample
            exampleexampleexampleexampleexampleexampleexampleexampleexampleexampleexampleexampleexampleexample
            exampleexampleexampleexampleexampleexampleexampleexampleexampleexampleexampleexampleexampleexample
            exampleexampleexampleexampleexampleexampleexampleexampleexampleexampleexampleexampleexampleexample
            exampleexampleexampleexampleexampleexampleexampleexampleexampleexampleexampleexampleexampleexample
            exampleexampleexampleexampleexampleexampleexampleexampleexampleexampleexampleexampleexampleexample
            exampleexampleexampleexampleexampleexampleexampleexampleexampleexampleexampleexampleexampleexample
            exampleexampleexampleexampleexampleexampleexampleexampleexampleexampleexampleexampleexampleexample
            exampleexampleexampleexampleexampleexampleexampleexampleexampleexampleexampleexampleexampleexample.com',
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->patchJson('/api/admin/about-us', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.url', [
                'The url must be a valid URL.',
                'The url must not be greater than 200 characters.'
            ]);
    }
}
