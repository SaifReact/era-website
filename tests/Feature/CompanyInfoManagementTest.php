<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Models\CompanyInfo;
use App\Models\User;
use Laravel\Sanctum\Sanctum;

/**
 * Class CompanyInfoManagementTest
 * @package Tests\Feature
 */
class CompanyInfoManagementTest extends TestCase
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

    public function company_info_can_be_added()
    {
        $payload = [
            'logo_src' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'logo_small_src' => 'http://laracms.local/cms_assets/378-200x200.jpg',
            'logo_alt' => 'logo_alt',
            'root_url' => 'root_url',
            'website_name' => 'website_name',
            'tagline' => 'tagline',
            'fax' => '+1111111111',
            'phone' => '+1111111111',
            'email' => 'email@example1.com',
            'web' => 'http://www.example.com',
            'facebook' => 'https://www.facebook.com/examplepage',
            'linkedin' => 'https://www.linkedin.com/examplepage',
            'company_summary' => 'company summary',
            'open_days' => 'Monday - Thursday',
            'duration' => '9:00 AM - 6:00 PM',
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->postJson('/api/admin/company-infos', $payload, $headers);

        $this->assertCount(1, CompanyInfo::all());

        $response->assertCreated();
    }

    /** @test */
    public function company_info_can_be_updated()
    {
        $headers = [
            'Accept' => 'application/json'
        ];

        $payload = [
            'logo_src' => 'http://laracms.local/cms_assets/25-200x300.jpg',
            'logo_small_src' => 'http://laracms.local/cms_assets/29-200x200.jpg',
            'logo_alt' => 'logo_alt1',
            'root_url' => 'root_url1',
            'website_name' => 'website_name1',
        ];

        $response = $this->patchJson('/api/admin/company-infos', $payload, $headers);

        $companyInfo1 = CompanyInfo::first();

        $response->assertOk();
        $this->assertEquals('http://laracms.local/cms_assets/25-200x300.jpg', $companyInfo1->logo_src);
        $this->assertEquals('http://laracms.local/cms_assets/29-200x200.jpg', $companyInfo1->logo_small_src);
        $this->assertEquals('logo_alt1', $companyInfo1->logo_alt);
        $this->assertEquals('root_url1', $companyInfo1->root_url);
        $this->assertEquals('website_name1', $companyInfo1->website_name);
    }

    public function company_info_can_be_destroyed()
    {
        $payload = [
            'logo_src' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'logo_small_src' => 'http://laracms.local/cms_assets/378-200x200.jpg',
            'logo_alt' => 'logo_alt',
            'root_url' => 'root_url',
            'website_name' => 'website_name',
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $this->postJson('/api/admin/company-infos', $payload, $headers);

        $this->assertCount(1, CompanyInfo::all());

        $companyInfo = CompanyInfo::first();

        $response = $this->deleteJson('/api/admin/company-infos/'.$companyInfo->id);

        $response->assertOk();

        $this->assertCount(0, CompanyInfo::all());
    }

    /** @test */
    public function company_info_can_be_viewed()
    {
        $headers = [
            'Accept' => 'application/json'
        ];

        $payload = [
            'logo_src' => 'http://laracms.local/cms_assets/25-200x300.jpg',
            'logo_small_src' => 'http://laracms.local/cms_assets/29-200x200.jpg',
            'logo_alt' => 'logo_alt',
            'root_url' => 'root_url',
            'website_name' => 'website_name',
        ];

        $this->patchJson('/api/admin/company-infos', $payload, $headers);

        $response = $this->getJson('/api/admin/company-infos');

        $companyInfo1 = CompanyInfo::first();

        $this->assertEquals('http://laracms.local/cms_assets/25-200x300.jpg', $companyInfo1->logo_src);
        $this->assertEquals('http://laracms.local/cms_assets/29-200x200.jpg', $companyInfo1->logo_small_src);
        $this->assertEquals('logo_alt', $companyInfo1->logo_alt);
        $this->assertEquals('root_url', $companyInfo1->root_url);
        $this->assertEquals('website_name', $companyInfo1->website_name);

        $response->assertOk();
    }

    public function company_info_can_be_listed()
    {
        $payload = [
            'logo_src' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'logo_small_src' => 'http://laracms.local/cms_assets/378-200x200.jpg',
            'logo_alt' => 'logo_alt',
            'root_url' => 'root_url',
            'website_name' => 'website_name',
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $this->postJson('/api/admin/company-infos', $payload, $headers);

        $payload1 = [
            'logo_src' => 'http://laracms.local/cms_assets/25-200x300.jpg',
            'logo_small_src' => 'http://laracms.local/cms_assets/29-200x200.jpg',
            'logo_alt' => 'logo_alt1',
            'root_url' => 'root_url1',
            'website_name' => 'website_name',
        ];

        $this->postJson('/api/admin/company-infos', $payload1, $headers);

        $companyInfos = CompanyInfo::all();

        $response = $this->getJson('/api/admin/company-infos');

        $this->assertCount(2, $companyInfos);
        $response->assertOk();
    }

    /** @test */
    public function company_info_logo_src_is_required()
    {
        $payload = [
            'logo_src' => '',
            'logo_small_src' => 'http://laracms.local/cms_assets/378-200x200.jpg',
            'logo_alt' => 'logo_alt',
            'root_url' => 'root_url',
            'website_name' => 'website_name',
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->patchJson('/api/admin/company-infos', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.logo_src', [
                'The logo src field is required.'
            ]);
    }

    /** @test */
    public function company_info_logo_src_should_have_correct_url_format()
    {
        $payload = [
            'logo_src' => 'emaiL@example1.com',
            'logo_small_src' => 'http://laracms.local/cms_assets/29-200x200.jpg',
            'logo_alt' => 'logo_alt',
            'root_url' => 'root_url',
            'website_name' => 'website_name',
            'web' => 'user@example.com'
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->patchJson('/api/admin/company-infos', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.logo_src', [
                'The logo src must be a valid URL.'
            ]);
    }

    /** @test */
    public function company_info_logo_src_should_have_minimum_length()
    {
        $payload = [
            'logo_src' => 'http://l.l',
            'logo_small_src' => 'http://laracms.local/cms_assets/378-200x200.jpg',
            'logo_alt' => 'logo_alt',
            'root_url' => 'root_url',
            'website_name' => 'website_name',
            'web' => 'user@example.com'
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->patchJson('/api/admin/company-infos', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.logo_src', [
                'The logo src must be at least 14 characters.'
            ]);
    }

    /** @test */
    public function company_info_logo_src_should_have_maximum_length()
    {
        $payload = [
            'logo_src' => 'http://laracms.local/cms_assets/1026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x300
            1026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x300
            1026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x300
            1026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x300
            1026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x300
            1026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x300
            1026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x300
            1026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x300
            1026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x300
            1026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x300
            1026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x300
            1026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x300.jpg',
            'logo_small_src' => 'http://laracms.local/cms_assets/378-200x200.jpg',
            'logo_alt' => 'logo_alt',
            'root_url' => 'root_url',
            'website_name' => 'website_name',
            'web' => 'user@example.com'
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->patchJson('/api/admin/company-infos', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.logo_src', [
                'The logo src must be a valid URL.',
                'The logo src must not be greater than 191 characters.'
            ]);
    }

    /** @test */
    public function company_info_logo_small_src_is_required()
    {
        $payload = [
            'logo_src' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'logo_small_src' => '',
            'logo_alt' => 'logo_alt',
            'root_url' => 'root_url',
            'website_name' => 'website_name',
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->patchJson('/api/admin/company-infos', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.logo_small_src', [
                'The logo small src field is required.'
            ]);
    }

    /** @test */
    public function company_info_logo_small_src_should_have_correct_url_format()
    {
        $payload = [
            'logo_src' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'logo_small_src' => 'email@example1.com',
            'logo_alt' => 'logo_alt',
            'root_url' => 'root_url',
            'website_name' => 'website_name',
            'web' => 'user@example.com'
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->patchJson('/api/admin/company-infos', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.logo_small_src', [
                'The logo small src must be a valid URL.'
            ]);
    }

    /** @test */
    public function company_info_logo_small_src_should_have_minimum_length()
    {
        $payload = [
            'logo_src' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'logo_small_src' => 'http://www.l',
            'logo_alt' => 'logo_alt',
            'root_url' => 'root_url',
            'website_name' => 'website_name',
            'web' => 'user@example.com'
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->patchJson('/api/admin/company-infos', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.logo_small_src', [
                'The logo small src must be at least 14 characters.'
            ]);
    }

    /** @test */
    public function company_info_logo_small_src_should_have_maximum_length()
    {
        $payload = [
            'logo_src' => 'http://laracms.local/cms_assets/25-200x300.jpg',
            'logo_small_src' => 'http://laracms.local/cms_assets/29-200x20029-200x20029-200x20029-200x20029-200x200
            29-200x20029-200x20029-200x20029-200x20029-200x20029-200x20029-200x20029-200x20029-200x20029-200x20029-200x200
            29-200x20029-200x20029-200x20029-200x20029-200x20029-200x20029-200x20029-200x20029-200x20029-200x20029-200x200
            29-200x20029-200x20029-200x20029-200x20029-200x20029-200x20029-200x20029-200x20029-200x20029-200x20029-200x200
            29-200x20029-200x20029-200x20029-200x20029-200x20029-200x20029-200x20029-200x20029-200x20029-200x20029-200x200
            29-200x20029-200x20029-200x20029-200x20029-200x20029-200x20029-200x20029-200x20029-200x20029-200x20029-200x200
            29-200x20029-200x20029-200x20029-200x20029-200x20029-200x20029-200x20029-200x20029-200x20029-200x20029-200x200
            29-200x20029-200x20029-200x20029-200x20029-200x20029-200x20029-200x20029-200x20029-200x20029-200x20029-200x200
            29-200x20029-200x20029-200x20029-200x20029-200x20029-200x20029-200x20029-200x20029-200x20029-200x20029-200x200
            29-200x20029-200x20029-200x20029-200x20029-200x20029-200x20029-200x20029-200x20029-200x20029-200x20029-200x200
            29-200x20029-200x20029-200x20029-200x20029-200x20029-200x20029-200x20029-200x20029-200x20029-200x20029-200x200
            29-200x20029-200x20029-200x20029-200x20029-200x20029-200x20029-200x20029-200x20029-200x20029-200x20029-200x200.jpg',
            'logo_alt' => 'logo_alt',
            'root_url' => 'root_url',
            'website_name' => 'website_name',
            'web' => 'user@example.com'
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->patchJson('/api/admin/company-infos', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.logo_small_src', [
                'The logo small src must be a valid URL.',
                'The logo small src must not be greater than 191 characters.'
            ]);
    }

    /** @test */
    public function company_info_email_should_have_correct_email_format()
    {
        $payload = [
            'logo_src' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'logo_small_src' => 'http://laracms.local/cms_assets/378-200x200.jpg',
            'logo_alt' => 'logo_alt',
            'root_url' => 'root_url',
            'website_name' => 'website_name',
            'email' => 'example.com'
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->patchJson('/api/admin/company-infos', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.email', [
                'The email must be a valid email address.'
            ]);
    }

    /** @test */
    public function company_info_web_should_have_correct_url_format()
    {
        $payload = [
            'logo_src' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'logo_small_src' => 'http://laracms.local/cms_assets/378-200x200.jpg',
            'logo_alt' => 'logo_alt',
            'root_url' => 'root_url',
            'website_name' => 'website_name',
            'web' => 'user@example.com'
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->patchJson('/api/admin/company-infos', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.web', [
                'The web must be a valid URL.'
            ]);
    }

    /** @test */
    public function company_info_facebook_should_have_correct_url_format()
    {
        $payload = [
            'logo_src' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'logo_small_src' => 'http://laracms.local/cms_assets/378-200x200.jpg',
            'logo_alt' => 'logo_alt',
            'root_url' => 'root_url',
            'website_name' => 'website_name',
            'facebook' => 'user@facebook.com'
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->patchJson('/api/admin/company-infos', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.facebook', [
                'The facebook must be a valid URL.'
            ]);
    }

    /** @test */
    public function company_info_linkedin_should_have_correct_url_format()
    {
        $payload = [
            'logo_src' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'logo_small_src' => 'http://laracms.local/cms_assets/378-200x200.jpg',
            'logo_alt' => 'logo_alt',
            'root_url' => 'root_url',
            'website_name' => 'website_name',
            'linkedin' => 'user@linkedin.com'
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->patchJson('/api/admin/company-infos', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.linkedin', [
                'The linkedin must be a valid URL.'
            ]);
    }

    /** @test */
    public function company_info_logo_alt_is_required()
    {
        $payload = [
            'logo_src' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'logo_small_src' => 'http://laracms.local/cms_assets/378-200x200.jpg',
            'logo_alt' => '',
            'root_url' => 'root_url',
            'website_name' => 'website_name',
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->patchJson('/api/admin/company-infos', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.logo_alt', [
                'The logo alt field is required.'
            ]);
    }

    /** @test */
    public function company_info_root_url_is_required()
    {
        $payload = [
            'logo_src' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'logo_small_src' => 'http://laracms.local/cms_assets/378-200x200.jpg',
            'logo_alt' => 'logo_alt',
            'root_url' => '',
            'website_name' => 'website_name',
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->patchJson('/api/admin/company-infos', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.root_url', [
                'The root url field is required.'
            ]);
    }

    /** @test */
    public function company_info_website_name_is_required()
    {
        $payload = [
            'logo_src' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'logo_small_src' => 'http://laracms.local/cms_assets/378-200x200.jpg',
            'logo_alt' => 'logo_alt',
            'root_url' => 'root_url',
            'website_name' => '',
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->patchJson('/api/admin/company-infos', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.website_name', [
                'The website name field is required.'
            ]);
    }

    /** @test */
    public function company_info_logo_alt_should_have_minimum_length()
    {
        $payload = [
            'logo_src' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'logo_small_src' => 'http://laracms.local/cms_assets/378-200x200.jpg',
            'logo_alt' => 'l',
            'root_url' => 'root_url',
            'website_name' => 'website_name',
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->patchJson('/api/admin/company-infos', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.logo_alt', [
                'The logo alt must be at least 3 characters.'
            ]);
    }

    /** @test  */
    public function company_info_logo_alt_should_have_maximum_length()
    {
        $payload = [
            'logo_src' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'logo_small_src' => 'http://laracms.local/cms_assets/378-200x200.jpg',
            'logo_alt' => 'logo_altlogo_altlogo_altlogo_altlogo_altlogo_altlogo_altlogo_altlogo_altlogo_altlogo_altlogo_altlogo_altlogo_altlogo_alt
            logo_altlogo_altlogo_altlogo_altlogo_altlogo_altlogo_altlogo_altlogo_altlogo_altlogo_altlogo_altlogo_altlogo_altlogo_altlogo_altlogo_alt
            logo_altlogo_altlogo_altlogo_altlogo_altlogo_altlogo_altlogo_altlogo_altlogo_altlogo_altlogo_altlogo_altlogo_altlogo_altlogo_altlogo_alt
            logo_altlogo_altlogo_altlogo_altlogo_altlogo_altlogo_altlogo_altlogo_altlogo_altlogo_altlogo_altlogo_altlogo_altlogo_altlogo_altlogo_alt
            logo_altlogo_altlogo_altlogo_altlogo_altlogo_altlogo_altlogo_altlogo_altlogo_altlogo_altlogo_altlogo_altlogo_altlogo_altlogo_altlogo_alt',
            'root_url' => 'root_url',
            'website_name' => 'website_name',
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->patchJson('/api/admin/company-infos', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.logo_alt', [
                'The logo alt must not be greater than 50 characters.'
            ]);
    }

    /** @test */
    public function company_info_root_url_should_have_minimum_length()
    {
        $payload = [
            'logo_src' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'logo_small_src' => 'http://laracms.local/cms_assets/378-200x200.jpg',
            'logo_alt' => 'logo_alt',
            'root_url' => '',
            'website_name' => 'website_name',
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->patchJson('/api/admin/company-infos', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.root_url', [
                'The root url field is required.'
            ]);
    }

    /** @test */
    public function company_info_root_url_should_have_maximum_length()
    {
        $payload = [
            'logo_src' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'logo_small_src' => 'http://laracms.local/cms_assets/378-200x200.jpg',
            'logo_alt' => 'logo_alt',
            'root_url' => 'root_urlroot_urlroot_urlroot_urlroot_urlroot_urlroot_urlroot_urlroot_urlroot_urlroot_url
            root_urlroot_urlroot_urlroot_urlroot_urlroot_urlroot_urlroot_urlroot_urlroot_urlroot_urlroot_urlroot_url
            root_urlroot_urlroot_urlroot_urlroot_urlroot_urlroot_urlroot_urlroot_urlroot_urlroot_urlroot_urlroot_url
            root_urlroot_urlroot_urlroot_urlroot_urlroot_urlroot_urlroot_urlroot_urlroot_urlroot_urlroot_urlroot_url
            root_urlroot_urlroot_urlroot_urlroot_urlroot_urlroot_urlroot_urlroot_urlroot_urlroot_urlroot_urlroot_url
            root_urlroot_urlroot_urlroot_urlroot_urlroot_urlroot_urlroot_urlroot_urlroot_urlroot_urlroot_urlroot_url
            root_urlroot_urlroot_urlroot_urlroot_urlroot_urlroot_urlroot_urlroot_urlroot_urlroot_urlroot_urlroot_url
            root_urlroot_urlroot_urlroot_urlroot_urlroot_urlroot_urlroot_urlroot_urlroot_urlroot_urlroot_urlroot_url
            root_urlroot_urlroot_urlroot_urlroot_urlroot_urlroot_urlroot_urlroot_urlroot_urlroot_urlroot_urlroot_url
            root_urlroot_urlroot_urlroot_urlroot_urlroot_urlroot_urlroot_urlroot_urlroot_urlroot_urlroot_urlroot_url
            root_urlroot_urlroot_urlroot_urlroot_urlroot_urlroot_urlroot_urlroot_urlroot_urlroot_urlroot_urlroot_url
            root_urlroot_urlroot_urlroot_urlroot_urlroot_urlroot_urlroot_urlroot_urlroot_urlroot_urlroot_urlroot_url
            root_urlroot_urlroot_urlroot_urlroot_urlroot_urlroot_urlroot_urlroot_urlroot_urlroot_urlroot_urlroot_url
            root_urlroot_urlroot_urlroot_urlroot_urlroot_urlroot_urlroot_urlroot_urlroot_urlroot_urlroot_urlroot_url
            root_urlroot_urlroot_urlroot_urlroot_urlroot_urlroot_urlroot_urlroot_urlroot_urlroot_urlroot_urlroot_url
            root_urlroot_urlroot_urlroot_urlroot_urlroot_urlroot_urlroot_urlroot_urlroot_urlroot_urlroot_urlroot_url',
            'website_name' => 'website_name',
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->patchJson('/api/admin/company-infos', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.root_url', [
                'The root url must not be greater than 200 characters.'
            ]);
    }

    /** @test */
    public function company_info_website_name_should_have_minimum_length()
    {
        $payload = [
            'logo_src' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'logo_small_src' => 'http://laracms.local/cms_assets/378-200x200.jpg',
            'logo_alt' => 'logo_alt',
            'root_url' => 'root_url',
            'website_name' => 'w',
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->patchJson('/api/admin/company-infos', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.website_name', [
                'The website name must be at least 3 characters.'
            ]);
    }

    /** @test */
    public function company_info_website_name_should_have_maximum_length()
    {
        $payload = [
            'logo_src' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'logo_small_src' => 'http://laracms.local/cms_assets/378-200x200.jpg',
            'logo_alt' => 'logo_alt',
            'root_url' => 'root_url',
            'website_name' => 'website_namewebsite_namewebsite_namewebsite_namewebsite_namewebsite_namewebsite_name
            website_namewebsite_namewebsite_namewebsite_namewebsite_namewebsite_namewebsite_namewebsite_name
            website_namewebsite_namewebsite_namewebsite_namewebsite_namewebsite_namewebsite_namewebsite_name
            website_namewebsite_namewebsite_namewebsite_namewebsite_namewebsite_namewebsite_namewebsite_name
            website_namewebsite_namewebsite_namewebsite_namewebsite_namewebsite_namewebsite_namewebsite_name
            website_namewebsite_namewebsite_namewebsite_namewebsite_namewebsite_namewebsite_namewebsite_name
            website_namewebsite_namewebsite_namewebsite_namewebsite_namewebsite_namewebsite_namewebsite_name',
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->patchJson('/api/admin/company-infos', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.website_name', [
                'The website name must not be greater than 50 characters.'
            ]);
    }

    /** @test */
    public function company_info_tagline_should_have_minimum_length()
    {
        $payload = [
            'logo_src' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'logo_small_src' => 'http://laracms.local/cms_assets/378-200x200.jpg',
            'logo_alt' => 'logo_alt',
            'root_url' => 'root_url',
            'website_name' => 'website_name',
            'tagline' => 't',
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->patchJson('/api/admin/company-infos', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.tagline', [
                'The tagline must be at least 3 characters.'
            ]);
    }

    /** @test */
    public function company_info_tagline_should_have_maximum_length()
    {
        $payload = [
            'logo_src' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'logo_small_src' => 'http://laracms.local/cms_assets/378-200x200.jpg',
            'logo_alt' => 'logo_alt',
            'root_url' => 'root_url',
            'website_name' => 'website_name',
            'tagline' => 'taglinetaglinetaglinetaglinetaglinetaglinetaglinetaglinetaglinetaglinetaglinetaglinetagline
            taglinetaglinetaglinetaglinetaglinetaglinetaglinetaglinetaglinetaglinetaglinetaglinetaglinetaglinetagline
            taglinetaglinetaglinetaglinetaglinetaglinetaglinetaglinetaglinetaglinetaglinetaglinetaglinetaglinetagline
            taglinetaglinetaglinetaglinetaglinetaglinetaglinetaglinetaglinetaglinetaglinetaglinetaglinetaglinetagline',
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->patchJson('/api/admin/company-infos', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.tagline', [
                'The tagline must not be greater than 100 characters.'
            ]);
    }

    /** @test */
    public function company_info_fax_should_have_minimum_length()
    {
        $payload = [
            'logo_src' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'logo_small_src' => 'http://laracms.local/cms_assets/378-200x200.jpg',
            'logo_alt' => 'logo_alt',
            'root_url' => 'root_url',
            'website_name' => 'website_name',
            'fax' => '123456',
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->patchJson('/api/admin/company-infos', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.fax', [
                'The fax must be at least 7 characters.'
            ]);
    }

    /** @test */
    public function company_info_fax_should_have_specific_accepted_characters()
    {
        $payload = [
            'logo_src' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'logo_small_src' => 'http://laracms.local/cms_assets/378-200x200.jpg',
            'logo_alt' => 'logo_alt',
            'root_url' => 'root_url',
            'website_name' => 'website_name',
            'fax' => '+a1111111111',
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->patchJson('/api/admin/company-infos', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.fax', [
                'The fax format is invalid.'
            ]);
    }

    /** @test */
    public function company_info_phone_should_have_minimum_length()
    {
        $payload = [
            'logo_src' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'logo_small_src' => 'http://laracms.local/cms_assets/378-200x200.jpg',
            'logo_alt' => 'logo_alt',
            'root_url' => 'root_url',
            'website_name' => 'website_name',
            'phone' => '123456',
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->patchJson('/api/admin/company-infos', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.phone', [
                'The phone must be at least 7 characters.'
            ]);
    }

    /** @test */
    public function company_info_phone_should_have_specific_accepted_characters()
    {
        $payload = [
            'logo_src' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'logo_small_src' => 'http://laracms.local/cms_assets/378-200x200.jpg',
            'logo_alt' => 'logo_alt',
            'root_url' => 'root_url',
            'website_name' => 'website_name',
            'phone' => '+a1111111111',
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->patchJson('/api/admin/company-infos', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.phone', [
                'The phone format is invalid.'
            ]);
    }

    /** @test */
    public function company_info_email_should_have_minimum_length()
    {
        $payload = [
            'logo_src' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'logo_small_src' => 'http://laracms.local/cms_assets/378-200x200.jpg',
            'logo_alt' => 'logo_alt',
            'root_url' => 'root_url',
            'website_name' => 'website_name',
            'email' => 'e@gm.co',
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->patchJson('/api/admin/company-infos', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.email', [
                'The email must be at least 8 characters.'
            ]);
    }

    /** @test */
    public function company_info_email_should_have_maximum_length()
    {
        $payload = [
            'logo_src' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'logo_small_src' => 'http://laracms.local/cms_assets/378-200x200.jpg',
            'logo_alt' => 'logo_alt',
            'root_url' => 'root_url',
            'website_name' => 'website_name',
            'email' => 'emailemailemailemailemailemailemailemailemailemailemailemailemailemailemailemailemail
            emailemailemailemailemailemailemailemailemailemailemailemailemailemailemailemailemailemailemailemail
            emailemailemailemailemailemailemailemailemailemailemailemailemailemailemailemailemailemailemailemail
            emailemailemailemailemailemailemailemailemailemailemailemailemailemailemailemailemailemailemailemail
            emailemailemailemailemailemailemailemailemailemailemailemailemailemailemailemailemailemailemailemail@gm.co',
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->patchJson('/api/admin/company-infos', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.email', [
                'The email must be a valid email address.',
                'The email must not be greater than 100 characters.'
            ]);
    }

    /** @test */
    public function company_info_web_should_have_minimum_length()
    {
        $payload = [
            'logo_src' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'logo_small_src' => 'http://laracms.local/cms_assets/378-200x200.jpg',
            'logo_alt' => 'logo_alt',
            'root_url' => 'root_url',
            'website_name' => 'website_name',
            'web' => 'http://www.e',
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->patchJson('/api/admin/company-infos', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.web', [
                'The web must be at least 14 characters.'
            ]);
    }

    /** @test */
    public function company_info_web_should_have_maximum_length()
    {
        $payload = [
            'logo_src' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'logo_small_src' => 'http://laracms.local/cms_assets/378-200x200.jpg',
            'logo_alt' => 'logo_alt',
            'root_url' => 'root_url',
            'website_name' => 'website_name',
            'web' => 'http://www.exampleexampleexampleexampleexampleexampleexampleexampleexampleexampleexampleexample
            exampleexampleexampleexampleexampleexampleexampleexampleexampleexampleexampleexampleexampleexampleexample
            exampleexampleexampleexampleexampleexampleexampleexampleexampleexampleexampleexampleexampleexampleexample
            exampleexampleexampleexampleexampleexampleexampleexampleexampleexampleexampleexampleexampleexampleexample
            exampleexampleexampleexampleexampleexampleexampleexampleexampleexampleexampleexampleexampleexampleexample
            exampleexampleexampleexampleexampleexampleexampleexampleexampleexampleexampleexampleexampleexample.com',
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->patchJson('/api/admin/company-infos', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.web', [
                'The web must be a valid URL.',
                'The web must not be greater than 200 characters.'
            ]);
    }

    /** @test */
    public function company_info_facebook_should_have_minimum_length()
    {
        $payload = [
            'logo_src' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'logo_small_src' => 'http://laracms.local/cms_assets/378-200x200.jpg',
            'logo_alt' => 'logo_alt',
            'root_url' => 'root_url',
            'website_name' => 'website_name',
            'facebook' => 'http://www.f',
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->patchJson('/api/admin/company-infos', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.facebook', [
                'The facebook must be at least 14 characters.'
            ]);
    }

    /** @test */
    public function company_info_facebook_should_have_maximum_length()
    {
        $payload = [
            'logo_src' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'logo_small_src' => 'http://laracms.local/cms_assets/378-200x200.jpg',
            'logo_alt' => 'logo_alt',
            'root_url' => 'root_url',
            'website_name' => 'website_name',
            'facebook' => 'http://www.facebook.com/exampleexampleexampleexampleexampleexampleexampleexampleexample
            exampleexampleexampleexampleexampleexampleexampleexampleexampleexampleexampleexampleexampleexampleexample
            exampleexampleexampleexampleexampleexampleexampleexampleexampleexampleexampleexampleexampleexampleexample
            exampleexampleexampleexampleexampleexampleexampleexampleexampleexampleexampleexampleexampleexampleexample
            exampleexampleexampleexampleexampleexampleexampleexampleexampleexampleexampleexampleexampleexampleexample
            exampleexampleexampleexampleexampleexampleexampleexampleexampleexampleexampleexampleexampleexampleexample
            exampleexampleexampleexampleexampleexampleexampleexampleexampleexampleexampleexampleexampleexample',
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->patchJson('/api/admin/company-infos', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.facebook', [
                'The facebook must be a valid URL.',
                'The facebook must not be greater than 200 characters.'
            ]);
    }

    /** @test */
    public function company_info_linkedin_should_have_minimum_length()
    {
        $payload = [
            'logo_src' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'logo_small_src' => 'http://laracms.local/cms_assets/378-200x200.jpg',
            'logo_alt' => 'logo_alt',
            'root_url' => 'root_url',
            'website_name' => 'website_name',
            'linkedin' => 'http://www.l',
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->patchJson('/api/admin/company-infos', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.linkedin', [
                'The linkedin must be at least 14 characters.'
            ]);
    }

    /** @test */
    public function company_info_linkedin_should_have_maximum_length()
    {
        $payload = [
            'logo_src' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'logo_small_src' => 'http://laracms.local/cms_assets/378-200x200.jpg',
            'logo_alt' => 'logo_alt',
            'root_url' => 'root_url',
            'website_name' => 'website_name',
            'linkedin' => 'http://www.linkedin.com/exampleexampleexampleexampleexampleexampleexampleexampleexample
            exampleexampleexampleexampleexampleexampleexampleexampleexampleexampleexampleexampleexampleexampleexample
            exampleexampleexampleexampleexampleexampleexampleexampleexampleexampleexampleexampleexampleexampleexample
            exampleexampleexampleexampleexampleexampleexampleexampleexampleexampleexampleexampleexampleexampleexample
            exampleexampleexampleexampleexampleexampleexampleexampleexampleexampleexampleexampleexampleexampleexample
            exampleexampleexampleexampleexampleexampleexampleexampleexampleexampleexampleexampleexampleexampleexample
            exampleexampleexampleexampleexampleexampleexampleexampleexampleexampleexampleexampleexampleexample',
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->patchJson('/api/admin/company-infos', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.linkedin', [
                'The linkedin must be a valid URL.',
                'The linkedin must not be greater than 200 characters.'
            ]);
    }

    /** @test */
    public function company_info_company_summary_should_have_minimum_length()
    {
        $payload = [
            'logo_src' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'logo_small_src' => 'http://laracms.local/cms_assets/378-200x200.jpg',
            'logo_alt' => 'logo_alt',
            'root_url' => 'root_url',
            'website_name' => 'website_name',
            'company_summary' => 'c',
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->patchJson('/api/admin/company-infos', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.company_summary', [
                'The company summary must be at least 10 characters.'
            ]);
    }

    /** @test */
    public function company_info_company_summary_should_have_maximum_length()
    {
        $payload = [
            'logo_src' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'logo_small_src' => 'http://laracms.local/cms_assets/378-200x200.jpg',
            'logo_alt' => 'logo_alt',
            'root_url' => 'root_url',
            'website_name' => 'website_name',
            'company_summary' => 'company_summarycompany_summarycompany_summarycompany_summarycompany_summary
            company_summarycompany_summarycompany_summarycompany_summarycompany_summarycompany_summarycompany_summary
            company_summarycompany_summarycompany_summarycompany_summarycompany_summarycompany_summarycompany_summary
            company_summarycompany_summarycompany_summarycompany_summarycompany_summarycompany_summarycompany_summary
            company_summarycompany_summarycompany_summarycompany_summarycompany_summarycompany_summarycompany_summary
            company_summarycompany_summarycompany_summarycompany_summarycompany_summarycompany_summarycompany_summary
            company_summarycompany_summarycompany_summarycompany_summarycompany_summarycompany_summarycompany_summary
            company_summarycompany_summarycompany_summarycompany_summarycompany_summarycompany_summarycompany_summary
            company_summarycompany_summarycompany_summarycompany_summarycompany_summarycompany_summarycompany_summary
            company_summarycompany_summarycompany_summarycompany_summarycompany_summarycompany_summarycompany_summary
            company_summarycompany_summarycompany_summarycompany_summarycompany_summarycompany_summarycompany_summary
            company_summarycompany_summarycompany_summarycompany_summarycompany_summarycompany_summarycompany_summary
            company_summarycompany_summarycompany_summarycompany_summarycompany_summarycompany_summarycompany_summary
            company_summarycompany_summarycompany_summarycompany_summarycompany_summarycompany_summarycompany_summary
            company_summarycompany_summarycompany_summarycompany_summarycompany_summarycompany_summarycompany_summary
            company_summarycompany_summarycompany_summarycompany_summarycompany_summarycompany_summarycompany_summary
            company_summarycompany_summarycompany_summarycompany_summarycompany_summarycompany_summarycompany_summary
            company_summarycompany_summarycompany_summarycompany_summarycompany_summarycompany_summarycompany_summary
            company_summarycompany_summarycompany_summarycompany_summarycompany_summarycompany_summarycompany_summary
            company_summarycompany_summarycompany_summarycompany_summarycompany_summarycompany_summarycompany_summary
            company_summarycompany_summarycompany_summarycompany_summarycompany_summarycompany_summarycompany_summary
            company_summarycompany_summarycompany_summarycompany_summarycompany_summarycompany_summarycompany_summary
            company_summarycompany_summarycompany_summarycompany_summarycompany_summarycompany_summarycompany_summary
            company_summarycompany_summarycompany_summarycompany_summarycompany_summarycompany_summarycompany_summary
            company_summarycompany_summarycompany_summarycompany_summarycompany_summarycompany_summarycompany_summary',
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->patchJson('/api/admin/company-infos', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.company_summary', [
                'The company summary must not be greater than 1000 characters.'
            ]);
    }

    /** @test */
    public function company_info_open_days_should_have_minimum_length()
    {
        $payload = [
            'logo_src' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'logo_small_src' => 'http://laracms.local/cms_assets/378-200x200.jpg',
            'logo_alt' => 'logo_alt',
            'root_url' => 'root_url',
            'website_name' => 'website_name',
            'open_days' => 'sun',
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->patchJson('/api/admin/company-infos', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.open_days', [
                'The open days must be at least 5 characters.'
            ]);
    }

    /** @test */
    public function company_info_open_days_should_have_maximum_length()
    {
        $payload = [
            'logo_src' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'logo_small_src' => 'http://laracms.local/cms_assets/378-200x200.jpg',
            'logo_alt' => 'logo_alt',
            'root_url' => 'root_url',
            'website_name' => 'website_name',
            'open_days' => 'sunday-thursdaysunday-thursdaysunday-thursdaysunday-thursdaysunday-thursdaysunday-thursday
            sunday-thursdaysunday-thursdaysunday-thursdaysunday-thursdaysunday-thursdaysunday-thursdaysunday-thursday
            sunday-thursdaysunday-thursdaysunday-thursdaysunday-thursdaysunday-thursdaysunday-thursdaysunday-thursday
            sunday-thursdaysunday-thursdaysunday-thursdaysunday-thursdaysunday-thursdaysunday-thursdaysunday-thursday
            sunday-thursdaysunday-thursdaysunday-thursdaysunday-thursdaysunday-thursdaysunday-thursdaysunday-thursday
            sunday-thursdaysunday-thursdaysunday-thursdaysunday-thursdaysunday-thursdaysunday-thursdaysunday-thursday',
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->patchJson('/api/admin/company-infos', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.open_days', [
                'The open days must not be greater than 100 characters.'
            ]);
    }

    /** @test */
    public function company_info_duration_should_have_minimum_length()
    {
        $payload = [
            'logo_src' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'logo_small_src' => 'http://laracms.local/cms_assets/378-200x200.jpg',
            'logo_alt' => 'logo_alt',
            'root_url' => 'root_url',
            'website_name' => 'website_name',
            'duration' => '9-5',
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->patchJson('/api/admin/company-infos', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.duration', [
                'The duration must be at least 5 characters.'
            ]);
    }

    /** @test */
    public function company_info_duration_should_have_maximum_length()
    {
        $payload = [
            'logo_src' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'logo_small_src' => 'http://laracms.local/cms_assets/378-200x200.jpg',
            'logo_alt' => 'logo_alt',
            'root_url' => 'root_url',
            'website_name' => 'website_name',
            'duration' => '9:00 AM - 5:00 PM,9:00 AM - 5:00 PM,9:00 AM - 5:00 PM,9:00 AM - 5:00 PM,9:00 AM - 5:00 PM,
            9:00 AM - 5:00 PM,9:00 AM - 5:00 PM,9:00 AM - 5:00 PM,9:00 AM - 5:00 PM,9:00 AM - 5:00 PM,9:00 AM - 5:00 PM,
            9:00 AM - 5:00 PM,9:00 AM - 5:00 PM,9:00 AM - 5:00 PM,9:00 AM - 5:00 PM,9:00 AM - 5:00 PM,9:00 AM - 5:00 PM,
            9:00 AM - 5:00 PM,9:00 AM - 5:00 PM,9:00 AM - 5:00 PM,9:00 AM - 5:00 PM,9:00 AM - 5:00 PM,9:00 AM - 5:00 PM,
            9:00 AM - 5:00 PM,9:00 AM - 5:00 PM,9:00 AM - 5:00 PM,9:00 AM - 5:00 PM,9:00 AM - 5:00 PM,9:00 AM - 5:00 PM,',
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->patchJson('/api/admin/company-infos', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.duration', [
                'The duration must not be greater than 50 characters.'
            ]);
    }
}
