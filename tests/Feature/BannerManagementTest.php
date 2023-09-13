<?php

namespace Tests\Feature;

use App\Models\Banner;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

/**
 * Class BannerManagementTest
 * @package Tests\Feature
 */
class BannerManagementTest extends TestCase
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
    public function banner_can_be_added()
    {
        $payload = [
            'banner_image' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'banner_text' => 'banner_text',
            'button_text' => 'button_text',
            'button_url' => 'http://www.example.com',
            'order' => 1
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->postJson('/api/admin/banners', $payload, $headers);

        $response->assertCreated();
        $this->assertCount(1, Banner::all());
    }

    /** @test */
    public function banner_can_be_updated()
    {
        $payload = [
            'banner_image' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'banner_text' => 'banner_text',
            'button_text' => 'button_text',
            'button_url' => 'http://www.example.com',
            'order' => 1
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $this->postJson('/api/admin/banners', $payload, $headers);

        $banner = Banner::first();

        $payload = [
            'banner_image' => 'http://laracms.local/cms_assets/25-200x300.jpg',
            'banner_text' => 'banner_text1',
            'button_text' => 'button_text1',
            'button_url' => 'http://www.example1.com',
            'order' => 2
        ];

        $response = $this->patchJson('/api/admin/banners/'. $banner->id, $payload, $headers);

        $banner1 = Banner::first();

        $response->assertOk();

        $this->assertEquals('http://laracms.local/cms_assets/25-200x300.jpg', $banner1->banner_image);
        $this->assertEquals('banner_text1', $banner1->banner_text);
        $this->assertEquals('button_text1', $banner1->button_text);
        $this->assertEquals('http://www.example1.com', $banner1->button_url);
        $this->assertEquals(2, $banner1->order);
    }

    /** @test */
    public function banner_can_be_deleted()
    {
        $payload = [
            'banner_image' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'banner_text' => 'banner_text',
            'button_text' => 'button_text',
            'button_url' => 'http://www.example.com',
            'order' => 1
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $this->postJson('/api/admin/banners', $payload, $headers);

        $this->assertCount(1, Banner::all());

        $response = $this->deleteJson('/api/admin/banners/'.Banner::first()->id);

        $this->assertCount(0, Banner::all());

        $response->assertOk();
    }

    /** @test */
    public function banner_can_be_viewed()
    {
        $payload = [
            'banner_image' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'banner_text' => 'banner_text',
            'button_text' => 'button_text',
            'button_url' => 'http://www.example.com',
            'order' => 1
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $this->postJson('/api/admin/banners', $payload, $headers);

        $banner = Banner::first();

        $response = $this->getJson('/api/admin/banners/'.$banner->id);

        $this->assertEquals('http://laracms.local/cms_assets/1026-200x300.jpg', $banner->banner_image);
        $this->assertEquals('banner_text', $banner->banner_text);
        $this->assertEquals('button_text', $banner->button_text);
        $this->assertEquals('http://www.example.com', $banner->button_url);
        $this->assertEquals(1, $banner->order);

        $response->assertOk();
    }

    /** @test */
    public function banner_can_be_listed()
    {
        $payload = [
            'banner_image' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'banner_text' => 'banner_text',
            'button_text' => 'button_text',
            'button_url' => 'http://www.example.com',
            'order' => 1
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $this->postJson('/api/admin/banners', $payload, $headers);

        $payload1 = [
            'banner_image' => 'http://laracms.local/cms_assets/25-200x300.jpg',
            'banner_text' => 'banner_text1',
            'button_text' => 'button_text1',
            'button_url' => 'http://www.example1.com',
            'order' => 2
        ];

        $this->postJson('/api/admin/banners', $payload1, $headers);

        $banners = Banner::all();

        $response = $this->getJson('/api/admin/banners');

        $this->assertCount(2, $banners);

        $response->assertOk();
    }

    /** @test */
    public function maximum_5_banner_can_be_added()
    {
        $payload = [
            'banner_image' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'banner_text' => 'banner_text',
            'button_text' => 'button_text',
            'button_url' => 'http://www.example.com',
            'order' => 1
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->postJson('/api/admin/banners', $payload, $headers);

        $response->assertCreated();

        $payload1 = [
            'banner_image' => 'http://laracms.local/cms_assets/25-200x300.jpg',
            'banner_text' => 'banner_text',
            'button_text' => 'button_text',
            'button_url' => 'http://www.example.com',
            'order' => 1
        ];

        $response = $this->postJson('/api/admin/banners', $payload1, $headers);

        $response->assertCreated();

        $payload2 = [
            'banner_image' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'banner_text' => 'banner_text',
            'button_text' => 'button_text',
            'button_url' => 'http://www.example.com',
            'order' => 1
        ];

        $response = $this->postJson('/api/admin/banners', $payload2, $headers);

        $response->assertCreated();

        $payload3 = [
            'banner_image' => 'http://laracms.local/cms_assets/25-200x300.jpg',
            'banner_text' => 'banner_text',
            'button_text' => 'button_text',
            'button_url' => 'http://www.example.com',
            'order' => 1
        ];

        $response = $this->postJson('/api/admin/banners', $payload3, $headers);

        $response->assertCreated();

        $payload4 = [
            'banner_image' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'banner_text' => 'banner_text',
            'button_text' => 'button_text',
            'button_url' => 'http://www.example.com',
            'order' => 1
        ];

        $response = $this->postJson('/api/admin/banners', $payload4, $headers);

        $response->assertCreated();

        $payload5 = [
            'banner_image' => 'http://laracms.local/cms_assets/25-200x300.jpg',
            'banner_text' => 'banner_text',
            'button_text' => 'button_text',
            'button_url' => 'http://www.example.com',
            'order' => 1
        ];

        $response = $this->postJson('/api/admin/banners', $payload5, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
                    ->assertJsonPath('errors.model', ['More than 5 banners is not permitted to add!']);

        $this->assertCount(5, Banner::all());
    }

    /** @test */
    public function banner_banner_image_is_required()
    {
        $payload = [
            'banner_image' => '',
            'banner_text' => 'banner_text',
            'button_text' => 'button_text',
            'button_url' => 'http://www.example.com',
            'order' => 1
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->postJson('/api/admin/banners', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.banner_image', ['The banner image field is required.']);
    }

    /** @test */
    public function banner_banner_image_should_have_correct_url_format()
    {
        $payload = [
            'banner_image' => 'email@example1.com',
            'banner_text' => 'banner_text',
            'button_text' => 'button_text',
            'button_url' => 'http://www.example.com',
            'order' => 1
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->postJson('/api/admin/banners', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.banner_image', [
                'The banner image must be a valid URL.'
            ]);
    }

    /** @test */
    public function banner_banner_image_should_have_minimum_length()
    {
        $payload = [
            'banner_image' => 'http://l.c',
            'banner_text' => 'banner_text',
            'button_text' => 'button_text',
            'button_url' => 'http://www.example.com',
            'order' => 1
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->postJson('/api/admin/banners', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.banner_image', [
                'The banner image must be at least 14 characters.'
            ]);
    }

    /** @test */
    public function banner_banner_image_should_have_maximum_length()
    {
        $payload = [
            'banner_image' => 'http://laracms.local/cms_assets/1026-200x3001026-200x3001026-200x3001026-200x3001026-200x300
            1026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x300
            1026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x300
            1026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x300
            1026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x300
            1026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x300
            1026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x300.jpg',
            'banner_text' => 'banner_text',
            'button_text' => 'button_text',
            'button_url' => 'http://www.example.com',
            'order' => 1
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->postJson('/api/admin/banners', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.banner_image', [
                'The banner image must be a valid URL.',
                'The banner image must not be greater than 191 characters.'
            ]);
    }

    /** @test */
    public function banner_banner_text_can_be_empty()
    {
        $payload = [
            'banner_image' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'banner_text' => '',
            'button_text' => 'button_text',
            'button_url' => 'http://www.example.com',
            'order' => 1
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->postJson('/api/admin/banners', $payload, $headers);

        $response->assertCreated();
    }

    /** @test */
    public function banner_banner_text_should_have_minimum_length()
    {
        $payload = [
            'banner_image' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'banner_text' => 'ba',
            'button_text' => 'button_text',
            'button_url' => 'http://www.example.com',
            'order' => 1
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->postJson('/api/admin/banners', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.banner_text', [
                'The banner text must be at least 3 characters.'
            ]);
    }

    /** @test */
    public function banner_banner_text_should_have_maximum_length()
    {
        $payload = [
            'banner_image' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'banner_text' => 'banner_textbanner_textbanner_textbanner_textbanner_textbanner_textbanner_textbanner_text
            banner_textbanner_textbanner_textbanner_textbanner_textbanner_textbanner_textbanner_textbanner_text
            banner_textbanner_textbanner_textbanner_textbanner_textbanner_textbanner_textbanner_textbanner_text
            banner_textbanner_textbanner_textbanner_textbanner_textbanner_textbanner_textbanner_textbanner_text
            banner_textbanner_textbanner_textbanner_textbanner_textbanner_textbanner_textbanner_textbanner_text
            banner_textbanner_textbanner_textbanner_textbanner_textbanner_textbanner_textbanner_textbanner_text
            banner_textbanner_textbanner_textbanner_textbanner_textbanner_textbanner_textbanner_textbanner_text',
            'button_text' => 'button_text',
            'button_url' => 'http://www.example.com',
            'order' => 1
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->postJson('/api/admin/banners', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.banner_text', [
                'The banner text must not be greater than 100 characters.'
            ]);
    }

    /** @test */
    public function banner_button_text_can_be_empty()
    {
        $payload = [
            'banner_image' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'banner_text' => 'banner_text',
            'button_text' => '',
            'button_url' => 'http://www.example.com',
            'order' => 1
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->postJson('/api/admin/banners', $payload, $headers);

        $response->assertCreated();
    }

    /** @test */
    public function banner_button_text_should_have_minimum_length()
    {
        $payload = [
            'banner_image' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'banner_text' => 'banner_text',
            'button_text' => 'a',
            'button_url' => 'http://www.example.com',
            'order' => 1
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->postJson('/api/admin/banners', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.button_text', [
                'The button text must be at least 2 characters.'
            ]);
    }

    /** @test */
    public function banner_button_text_should_have_maximum_length()
    {
        $payload = [
            'banner_image' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'banner_text' => 'banner_text',
            'button_text' => 'button_textbutton_textbutton_textbutton_textbutton_textbutton_textbutton_text
            button_textbutton_textbutton_textbutton_textbutton_textbutton_textbutton_textbutton_textbutton_text
            button_textbutton_textbutton_textbutton_textbutton_textbutton_textbutton_textbutton_textbutton_text
            button_textbutton_textbutton_textbutton_textbutton_textbutton_textbutton_textbutton_textbutton_text
            button_textbutton_textbutton_textbutton_textbutton_textbutton_textbutton_textbutton_textbutton_text',
            'button_url' => 'http://www.example.com',
            'order' => 1
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->postJson('/api/admin/banners', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.button_text', [
                'The button text must not be greater than 100 characters.'
            ]);
    }

    /** @test */
    public function banner_button_url_should_have_correct_url_format()
    {
        $payload = [
            'banner_image' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'banner_text' => 'banner_text',
            'button_text' => 'button_text',
            'button_url' => 'example@url.com',
            'order' => 1
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->postJson('/api/admin/banners', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.button_url', [
                'The button url must be a valid URL.'
            ]);
    }

    /** @test */
    public function banner_button_url_can_be_empty()
    {
        $payload = [
            'banner_image' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'banner_text' => 'banner_text',
            'button_text' => 'button_text',
            'button_url' => '',
            'order' => 1
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->postJson('/api/admin/banners', $payload, $headers);

        $response->assertCreated();
    }

    /** @test */
    public function banner_button_url_should_have_minimum_length()
    {
        $payload = [
            'banner_image' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'banner_text' => 'banner_text',
            'button_text' => 'button_text',
            'button_url' => 'http://www.l',
            'order' => 1
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->postJson('/api/admin/banners', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.button_url', [
                'The button url must be at least 14 characters.'
            ]);
    }

    /** @test */
    public function banner_button_url_should_have_maximum_length()
    {
        $payload = [
            'banner_image' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'banner_text' => 'banner_text',
            'button_text' => 'button_text',
            'button_url' => 'http://www.exampleexampleexampleexampleexampleexampleexampleexampleexample
            exampleexampleexampleexampleexampleexampleexampleexampleexampleexampleexampleexampleexampleexample
            exampleexampleexampleexampleexampleexampleexampleexampleexampleexampleexampleexampleexampleexample.com',
            'order' => 1
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->postJson('/api/admin/banners', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.button_url', [
                'The button url must be a valid URL.',
                'The button url must not be greater than 200 characters.'
            ]);
    }

    /** @test */
    public function banner_order_is_required()
    {
        $payload = [
            'banner_image' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'banner_text' => 'banner_text',
            'button_text' => 'button_text',
            'button_url' => 'http://www.example.com',
            'order' => null
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->postJson('/api/admin/banners', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.order', [
                'The order field is required.'
            ]);
    }

    /** @test */
    public function banner_order_should_be_integer_type()
    {
        $payload = [
            'banner_image' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'banner_text' => 'banner_text',
            'button_text' => 'button_text',
            'button_url' => 'http://www.example.com',
            'order' => 'a'
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->postJson('/api/admin/banners', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.order', [
                'The order must be an integer.'
            ]);
    }
}
