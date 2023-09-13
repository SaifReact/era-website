<?php

namespace Tests\Feature;

use App\Models\Portfolio;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

/**
 * Class PortfolioManagementTest
 * @package Tests\Feature
 */
class PortfolioManagementTest extends TestCase
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
    public function portfolio_can_be_added()
    {
        $payload = [
            'thumbnail' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'image' => 'http://laracms.local/cms_assets/378-200x200.jpg',
            'name' => 'namename',
            'portfolio_category_id' => 1,
            'detail' => 'detail',
            'order' => 1
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->postJson('/api/admin/portfolios', $payload, $headers);

        $this->assertCount(1, Portfolio::all());
        $response->assertCreated();
    }

    /** @test */
    public function  portfolio_can_be_updated()
    {
        $payload = [
            'thumbnail' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'image' => 'http://laracms.local/cms_assets/378-200x200.jpg',
            'name' => 'namename',
            'portfolio_category_id' => 1,
            'detail' => 'detail',
            'order' => 1
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $this->postJson('/api/admin/portfolios', $payload, $headers);

        $portfolio = Portfolio::first();

        $payload1 = [
            'thumbnail' => 'http://laracms.local/cms_assets/25-200x300.jpg',
            'image' => 'http://laracms.local/cms_assets/29-200x200.jpg',
            'name' => 'namename1',
            'portfolio_category_id' => 2,
            'detail' => 'detail1',
            'order' => 2
        ];

        $response = $this->patchJson("/api/admin/portfolios/{$portfolio->id}", $payload1, $headers);

        $portfolio1 = Portfolio::first();

        $this->assertEquals('http://laracms.local/cms_assets/25-200x300.jpg', $portfolio1->thumbnail);
        $this->assertEquals('http://laracms.local/cms_assets/29-200x200.jpg', $portfolio1->image);
        $this->assertEquals('namename1', $portfolio1->name);
        $this->assertEquals(2, $portfolio1->portfolio_category_id);
        $this->assertEquals('detail1', $portfolio1->detail);
        $this->assertEquals(2, $portfolio1->order);

        $response->assertOk();
    }

    /** @test */
    public function portfolio_can_be_deleted()
    {
        $payload = [
            'thumbnail' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'image' => 'http://laracms.local/cms_assets/378-200x200.jpg',
            'name' => 'namename',
            'portfolio_category_id' => 1,
            'detail' => 'detail',
            'order' => 1
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $this->postJson('/api/admin/portfolios', $payload, $headers);

        $this->assertCount(1, Portfolio::all());

        $portfolio = Portfolio::first();
        $response = $this->deleteJson("/api/admin/portfolios/{$portfolio->id}");

        $this->assertCount(0, Portfolio::all());

        $response->assertOk();
    }

    /** @test */
    public function portfolio_can_be_viewed()
    {
        $payload = [
            'thumbnail' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'image' => 'http://laracms.local/cms_assets/378-200x200.jpg',
            'name' => 'namename',
            'portfolio_category_id' => 1,
            'detail' => 'detail',
            'order' => 1
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $this->postJson('/api/admin/portfolios', $payload, $headers);

        $portfolio = Portfolio::first();
        $response = $this->getJson("/api/admin/portfolios/{$portfolio->id}");

        $this->assertEquals('http://laracms.local/cms_assets/1026-200x300.jpg', $portfolio->thumbnail);
        $this->assertEquals('http://laracms.local/cms_assets/378-200x200.jpg', $portfolio->image);
        $this->assertEquals('namename', $portfolio->name);
        $this->assertEquals(1, $portfolio->portfolio_category_id);
        $this->assertEquals('detail', $portfolio->detail);
        $this->assertEquals(1, $portfolio->order);

        $response->assertOk();
    }

    /** @test */
    public function portfolio_can_be_listed()
    {
        $payload = [
            'thumbnail' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'image' => 'http://laracms.local/cms_assets/378-200x200.jpg',
            'name' => 'namename',
            'portfolio_category_id' => 1,
            'detail' => 'detail',
            'order' => 1
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $this->postJson('/api/admin/portfolios', $payload, $headers);

        $this->assertCount(1, Portfolio::all());

        $payload1 = [
            'thumbnail' => 'http://laracms.local/cms_assets/25-200x300.jpg',
            'image' => 'http://laracms.local/cms_assets/29-200x200.jpg',
            'name' => 'namename1',
            'portfolio_category_id' => 2,
            'detail' => 'detail1',
            'order' => 2
        ];

        $this->postJson('/api/admin/portfolios', $payload1, $headers);

        $response = $this->getJson('/api/admin/portfolios');

        $this->assertCount(2, Portfolio::all());

        $response->assertOk();
    }

    /** @test */
    public function portfolio_thumbnail_is_required()
    {
        $payload = [
            'thumbnail' => '',
            'image' => 'http://laracms.local/cms_assets/378-200x200.jpg',
            'name' => 'namename',
            'portfolio_category_id' => 1,
            'detail' => 'detail',
            'order' => 1
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->postJson('/api/admin/portfolios', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.thumbnail', [
                'The thumbnail field is required.'
            ]);
    }

    /** @test */
    public function portfolio_thumbnail_should_have_correct_url_format()
    {
        $payload = [
            'thumbnail' => 'email@example1.com',
            'image' => 'http://laracms.local/cms_assets/378-200x200.jpg',
            'name' => 'namename',
            'portfolio_category_id' => 1,
            'detail' => 'detail',
            'order' => 1
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->postJson('/api/admin/portfolios', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.thumbnail', [
                'The thumbnail must be a valid URL.'
            ]);
    }

    /** @test */
    public function portfolio_thumbnail_should_have_minimum_length()
    {
        $payload = [
            'thumbnail' => 'http://www.l',
            'image' => 'http://laracms.local/cms_assets/378-200x200.jpg',
            'name' => 'namename',
            'portfolio_category_id' => 1,
            'detail' => 'detail',
            'order' => 1
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->postJson('/api/admin/portfolios', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.thumbnail', [
                'The thumbnail must be at least 14 characters.'
            ]);
    }

    /** @test */
    public function portfolio_thumbnail_should_have_maximum_length()
    {
        $payload = [
            'thumbnail' => 'http://laracms.local/cms_assets/1026-200x3001026-200x3001026-200x3001026-200x3001026-200x300
            1026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x300
            1026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x300
            1026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x300
            1026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x300
            1026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x300.jpg',
            'image' => 'http://laracms.local/cms_assets/378-200x200.jpg',
            'name' => 'namename',
            'portfolio_category_id' => 1,
            'detail' => 'detail',
            'order' => 1
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->postJson('/api/admin/portfolios', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.thumbnail', [
                'The thumbnail must be a valid URL.',
                'The thumbnail must not be greater than 191 characters.'
            ]);
    }

    /** @test */
    public function portfolio_image_is_required()
    {
        $payload = [
            'thumbnail' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'image' => '',
            'name' => 'namename',
            'portfolio_category_id' => 1,
            'detail' => 'detail',
            'order' => 1
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->postJson('/api/admin/portfolios', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.image', [
                'The image field is required.'
            ]);
    }


    /** @test */
    public function portfolio_image_should_have_correct_url_format()
    {
        $payload = [
            'thumbnail' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'image' => 'email@example1.com',
            'name' => 'namename',
            'portfolio_category_id' => 1,
            'detail' => 'detail',
            'order' => 1
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->postJson('/api/admin/portfolios', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.image', [
                'The image must be a valid URL.'
            ]);
    }

    /** @test */
    public function portfolio_image_should_have_minimum_length()
    {
        $payload = [
            'thumbnail' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'image' => 'http://www.l',
            'name' => 'namename',
            'portfolio_category_id' => 1,
            'detail' => 'detail',
            'order' => 1
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->postJson('/api/admin/portfolios', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.image', [
                'The image must be at least 14 characters.'
            ]);
    }

    /** @test */
    public function portfolio_image_should_have_maximum_length()
    {
        $payload = [
            'thumbnail' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'image' => 'http://laracms.local/cms_assets/378-200x200378-200x200378-200x200378-200x200378-200x200
            378-200x200378-200x200378-200x200378-200x200378-200x200378-200x200378-200x200378-200x200378-200x200
            378-200x200378-200x200378-200x200378-200x200378-200x200378-200x200378-200x200378-200x200378-200x200
            378-200x200378-200x200378-200x200378-200x200378-200x200378-200x200378-200x200378-200x200378-200x200
            378-200x200378-200x200378-200x200378-200x200378-200x200378-200x200378-200x200378-200x200378-200x200
            378-200x200378-200x200378-200x200378-200x200378-200x200378-200x200378-200x200378-200x200378-200x200
            378-200x200378-200x200378-200x200378-200x200378-200x200378-200x200378-200x200378-200x200378-200x200.jpg',
            'name' => 'namename',
            'portfolio_category_id' => 1,
            'detail' => 'detail',
            'order' => 1
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->postJson('/api/admin/portfolios', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.image', [
                'The image must be a valid URL.',
                'The image must not be greater than 191 characters.'
            ]);
    }

    /** @test */
    public function portfolio_name_is_required()
    {
        $payload = [
            'thumbnail' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'image' => 'http://laracms.local/cms_assets/378-200x200.jpg',
            'name' => '',
            'portfolio_category_id' => 1,
            'detail' => 'detail',
            'order' => 1
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->postJson('/api/admin/portfolios', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.name', [
                'The name field is required.'
            ]);
    }

    /** @test */
    public function portfolio_name_should_have_minimum_length()
    {
        $payload = [
            'thumbnail' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'image' => 'http://laracms.local/cms_assets/378-200x200.jpg',
            'name' => 'n',
            'portfolio_category_id' => 1,
            'detail' => 'detail',
            'order' => 1
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->postJson('/api/admin/portfolios', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.name', [
                'The name must be at least 3 characters.'
            ]);
    }

    /** @test */
    public function portfolio_name_should_have_maximum_length()
    {
        $payload = [
            'thumbnail' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'image' => 'http://laracms.local/cms_assets/378-200x200.jpg',
            'name' => 'namenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamename
            namenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamename
            namenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamename
            namenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamename
            namenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamename
            namenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamename
            namenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamenamename',
            'portfolio_category_id' => 1,
            'detail' => 'detail',
            'order' => 1
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->postJson('/api/admin/portfolios', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.name', [
                'The name must not be greater than 100 characters.'
            ]);
    }

    /** @test */
    public function portfolio_portfolio_category_id_is_required()
    {
        $payload = [
            'thumbnail' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'image' => 'http://laracms.local/cms_assets/378-200x200.jpg',
            'name' => 'namename',
            'portfolio_category_id' => null,
            'detail' => 'detail',
            'order' => 1
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->postJson('/api/admin/portfolios', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.portfolio_category_id', [
                'The portfolio category id field is required.'
            ]);
    }

    /** @test */
    public function portfolio_portfolio_category_id_should_be_integer_type()
    {
        $payload = [
            'thumbnail' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'image' => 'http://laracms.local/cms_assets/378-200x200.jpg',
            'name' => 'namename',
            'portfolio_category_id' => 'a',
            'detail' => 'detail',
            'order' => 1
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->postJson('/api/admin/portfolios', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.portfolio_category_id', [
                'The portfolio category id must be an integer.'
            ]);
    }

    /** @test */
    public function portfolio_detail_is_required()
    {
        $payload = [
            'thumbnail' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'image' => 'http://laracms.local/cms_assets/378-200x200.jpg',
            'name' => '',
            'portfolio_category_id' => 1,
            'detail' => '',
            'order' => 1
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->postJson('/api/admin/portfolios', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.detail', [
                'The detail field is required.'
            ]);
    }

    /** @test */
    public function portfolio_detail_should_have_minimum_length()
    {
        $payload = [
            'thumbnail' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'image' => 'http://laracms.local/cms_assets/378-200x200.jpg',
            'name' => 'namename',
            'portfolio_category_id' => 1,
            'detail' => 'd',
            'order' => 1
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->postJson('/api/admin/portfolios', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.detail', [
                'The detail must be at least 3 characters.'
            ]);
    }

    public function portfolio_detail_should_have_maximum_length()
    {
        $randomLetter = '';
        $length = 10000;

        for ($index = 0; $index <= $length; $index++) {
            $randomLetter .= substr(str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ.123456789~!@#$%^&*
        ()_-+=`<,>.?/:;'\"[]{}\\|"), 0, 10);
        }

        $payload = [
            'thumbnail' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'image' => 'http://laracms.local/cms_assets/378-200x200.jpg',
            'name' => 'namename',
            'portfolio_category_id' => 1,
            'detail' => $randomLetter,
            'order' => 1
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->postJson('/api/admin/portfolios', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.detail', [
                'The detail must not be greater than 10000 characters.'
            ]);
    }

    /** @test */
    public function portfolio_order_is_required()
    {
        $payload = [
            'thumbnail' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'image' => 'http://laracms.local/cms_assets/378-200x200.jpg',
            'name' => 'namename',
            'portfolio_category_id' => 1,
            'detail' => 'detail',
            'order' => null
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->postJson('/api/admin/portfolios', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.order', [
                'The order field is required.'
            ]);
    }

    /** @test */
    public function portfolio_order_should_be_integer_type()
    {
        $payload = [
            'thumbnail' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'image' => 'http://laracms.local/cms_assets/378-200x200.jpg',
            'name' => 'namename',
            'portfolio_category_id' => 1,
            'detail' => 'detail',
            'order' => 'a'
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->postJson('/api/admin/portfolios', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.order', [
                'The order must be an integer.'
            ]);
    }
}
