<?php

namespace Tests\Feature;

use App\Models\Page;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

/**
 * Class PageManagementTest
 * @package Tests\Feature
 */
class PageManagementTest extends TestCase
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
    public function page_can_be_added()
    {
        $payload = [
            'title'=>'title',
            'slug'=>'title',
            'content'=>'content',
            'meta'=>'meta1, meta2, meta3, meta4'
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->postJson('/api/admin/pages', $payload, $headers);

        $this->assertCount(25, Page::all());
        $response->assertCreated();
    }

    /** @test */
    public function page_can_be_updated()
    {
        $payload = [
            'title'=>'title',
            'slug'=>'title',
            'content'=>'content',
            'meta'=>'meta1, meta2, meta3, meta4'
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $this->postJson('/api/admin/pages', $payload, $headers);

        $page = Page::orderBy('id', 'DESC')->first();

        $response = $this->patchJson("/api/admin/pages/{$page->id}", [
            'title'=>'title1',
            'slug'=>'title1',
            'content'=>'content1',
            'meta'=>'meta5, meta6, meta7, meta8'
        ]);

        $page1 = Page::orderBy('id', 'DESC')->first();

        $this->assertEquals('title1', $page1->title);
        $this->assertEquals('title1', $page1->slug);
        $this->assertEquals('content1', $page1->content);
        $this->assertEquals('meta5, meta6, meta7, meta8', $page1->meta);

        $response->assertOk();
    }

    /** @test */
    public function page_can_be_deleted()
    {
        $payload = [
            'title'=>'title',
            'slug'=>'title',
            'content'=>'content',
            'meta'=>'meta1, meta2, meta3, meta4'
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $this->postJson('/api/admin/pages', $payload, $headers);

        $this->assertCount(25, Page::all());
        $page = Page::orderBy('id', 'DESC')->first();

        $response = $this->deleteJson("/api/admin/pages/{$page->id}");
        $this->assertCount(24, Page::all());

        $response->assertOk();
    }

    /** @test */
    public function page_can_be_viewed()
    {
        $payload = [
            'title'=>'title',
            'slug'=>'title',
            'content'=>'content',
            'meta'=>'meta1, meta2, meta3, meta4'
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $this->postJson('/api/admin/pages', $payload, $headers);

        $page = Page::orderBy('id', 'DESC')->first();

        $response = $this->getJson("/api/admin/pages/{$page->id}");

        $this->assertEquals('title', $page->title);
        $this->assertEquals('title', $page->slug);
        $this->assertEquals('content', $page->content);
        $this->assertEquals('meta1, meta2, meta3, meta4', $page->meta);

        $response->assertOk();
    }

    /** @test */
    public function page_can_be_listed()
    {
        $payload = [
            'title'=>'title',
            'slug'=>'title',
            'content'=>'content',
            'meta'=>'meta1, meta2, meta3, meta4'
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $this->postJson('/api/admin/pages', $payload, $headers);

        $payload1 = [
            'title'=>'title1',
            'slug'=>'title1',
            'content'=>'content1',
            'meta'=>'meta5, meta6, meta7, meta8'
        ];

        $this->postJson('/api/admin/pages', $payload, $headers);

        $response = $this->getJson('/api/admin/pages');

        $response->assertOk();
    }

    /** @test */
    public function page_title_is_required()
    {
        $payload = [
            'title'=>'',
            'slug'=>'',
            'content'=>'content',
            'meta'=>'meta1, meta2, meta3, meta4'
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->postJson('/api/admin/pages', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.title', [
                'The title field is required.'
            ]);
    }

    /** @test */
    public function page_title_should_be_unique()
    {
        $payload = [
            'title'=>'title',
            'slug'=>'title',
            'content'=>'content',
            'meta'=>'meta1, meta2, meta3, meta4'
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $this->postJson('/api/admin/pages', $payload, $headers);

        $payload1 = [
            'title'=>'title',
            'slug'=>'title1',
            'content'=>'content1',
            'meta'=>'meta5, meta6, meta7, meta8'
        ];

        $response = $this->postJson('/api/admin/pages', $payload1, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.title', [
                'The title has already been taken.'
            ]);
    }

    /** @test */
    public function page_title_should_have_minimum_length()
    {
        $payload = [
            'title'=>'t',
            'slug'=>'t',
            'content'=>'content',
            'meta'=>'meta1, meta2, meta3, meta4'
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->postJson('/api/admin/pages', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.title', [
                'The title must be at least 3 characters.'
            ]);
    }

    /** @test */
    public function page_title_should_have_maximum_length()
    {
        $payload = [
            'title'=>'titletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitle
            titletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitle
            titletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitle
            titletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitle
            titletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitle
            titletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitle
            titletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitle',
            'slug'=>'titletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitle
            titletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitle
            titletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitle
            titletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitle
            titletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitle
            titletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitle
            titletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitle',
            'content'=>'content',
            'meta'=>'meta1, meta2, meta3, meta4'
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->postJson('/api/admin/pages', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.title', [
                'The title must not be greater than 150 characters.'
            ]);
    }

    /** @test */
    public function page_slug_should_be_unique()
    {
        $payload = [
            'title'=>'title',
            'slug'=>'title',
            'content'=>'content',
            'meta'=>'meta1, meta2, meta3, meta4'
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $this->postJson('/api/admin/pages', $payload, $headers);

        $payload1 = [
            'title'=>'title1',
            'slug'=>'title',
            'content'=>'content1',
            'meta'=>'meta5, meta6, meta7, meta8'
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->postJson('/api/admin/pages', $payload1, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.slug', [
                'The slug has already been taken.'
            ]);
    }

    /** @test */
    public function page_slug_should_have_minimum_length()
    {
        $payload = [
            'title'=>'t',
            'slug'=>'t',
            'content'=>'content',
            'meta'=>'meta1, meta2, meta3, meta4'
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->postJson('/api/admin/pages', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.slug', [
                'The slug must be at least 3 characters.'
            ]);
    }

    /** @test */
    public function page_slug_should_have_maximum_length()
    {
        $payload = [
            'title'=>'titletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitle
            titletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitle
            titletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitle
            titletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitle
            titletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitle
            titletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitle
            titletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitle',
            'slug'=>'titletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitle
            titletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitle
            titletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitle
            titletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitle
            titletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitle
            titletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitle
            titletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitle',
            'content'=>'content',
            'meta'=>'meta1, meta2, meta3, meta4'
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->postJson('/api/admin/pages', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.slug', [
                'The slug must not be greater than 200 characters.'
            ]);
    }

    /** @test */
    public function page_content_is_required()
    {
        $payload = [
            'title'=>'title',
            'slug'=>'title',
            'content'=>'',
            'meta'=>'meta1, meta2, meta3, meta4'
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->postJson('/api/admin/pages', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.content', [
                'The content field is required.'
            ]);
    }

    /** @test */
    public function page_content_should_have_minimum_length()
    {
        $payload = [
            'title'=>'title',
            'slug'=>'title',
            'content'=>'c',
            'meta'=>'meta1, meta2, meta3, meta4'
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->postJson('/api/admin/pages', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.content', [
                'The content must be at least 3 characters.'
            ]);
    }

    public function page_content_should_have_maximum_length()
    {
        $payload = [
            'title'=>'title',
            'slug'=>'title',
            'content'=>'contentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontent
            contentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontent
            contentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontent
            contentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontent
            contentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontent
            contentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontent
            contentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontent
            contentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontent
            contentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontent
            contentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontent
            contentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontent
            contentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontent
            contentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontent
            contentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontent
            contentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontent
            contentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontent
            contentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontent
            contentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontent
            contentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontent
            contentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontent
            contentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontent
            contentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontent
            contentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontent
            contentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontent
            contentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontent
            contentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontent
            contentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontent
            contentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontent
            contentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontent
            contentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontent
            contentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontent
            contentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontent
            contentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontent
            contentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontent
            contentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontent
            contentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontent
            contentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontent
            contentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontent
            contentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontent
            contentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontent
            contentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontent
            contentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontent
            contentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontent
            contentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontent
            contentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontent
            contentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontent
            contentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontent
            contentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontent
            contentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontent
            contentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontent
            contentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontent
            contentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontent
            contentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontent
            contentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontent
            contentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontent
            contentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontent
            contentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontent
            contentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontent
            contentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontent
            contentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontent
            contentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontent
            contentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontent
            contentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontent
            contentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontent
            contentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontent
            contentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontent
            contentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontent
            contentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontent
            contentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontent
            contentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontent
            contentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontent
            contentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontent
            contentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontent
            contentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontent
            contentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontent
            contentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontent
            contentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontent
            contentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontent
            contentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontent
            contentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontent
            contentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontent
            contentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontent
            contentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontent
            contentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontent
            contentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontent
            contentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontent
            contentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontent
            contentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontent
            contentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontent
            contentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontent
            contentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontent
            contentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontent
            contentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontent
            contentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontent
            contentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontent
            contentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontent
            contentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontent
            contentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontent
            contentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontent
            contentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontent
            contentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontent
            contentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontent
            contentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontent
            contentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontent
            contentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontent
            contentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontent
            contentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontent
            contentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontent
            contentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontent
            contentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontent
            contentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontent
            contentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontent
            contentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontent
            contentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontent
            contentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontent
            contentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontent
            contentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontent
            contentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontent
            contentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontent
            contentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontent
            contentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontent',
            'meta'=>'meta1, meta2, meta3, meta4'
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->postJson('/api/admin/pages', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.content', [
                'The content must not be greater than 10000 characters.'
            ]);
    }

    /** @test */
    public function page_meta_should_have_minimum_length()
    {
        $payload = [
            'title'=>'title',
            'slug'=>'title',
            'content'=>'content',
            'meta'=>'m'
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->postJson('/api/admin/pages', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.meta', [
                'The meta must be at least 3 characters.'
            ]);
    }

    /** @test */
    public function page_meta_should_have_maximum_length()
    {
        $payload = [
            'title'=>'title',
            'slug'=>'title',
            'content'=>'content',
            'meta'=>'meta1, meta2, meta3, meta4,meta1, meta2, meta3, meta4,meta1, meta2, meta3, meta4,
            meta1, meta2, meta3, meta4,meta1, meta2, meta3, meta4,meta1, meta2, meta3, meta4,meta1, meta2, meta3, meta4,
            meta1, meta2, meta3, meta4,meta1, meta2, meta3, meta4,meta1, meta2, meta3, meta4,meta1, meta2, meta3, meta4,
            meta1, meta2, meta3, meta4,meta1, meta2, meta3, meta4,meta1, meta2, meta3, meta4,meta1, meta2, meta3, meta4,
            meta1, meta2, meta3, meta4,meta1, meta2, meta3, meta4,meta1, meta2, meta3, meta4,meta1, meta2, meta3, meta4,
            meta1, meta2, meta3, meta4,meta1, meta2, meta3, meta4,meta1, meta2, meta3, meta4,meta1, meta2, meta3, meta4,
            meta1, meta2, meta3, meta4,meta1, meta2, meta3, meta4,meta1, meta2, meta3, meta4,meta1, meta2, meta3, meta4,
            meta1, meta2, meta3, meta4,meta1, meta2, meta3, meta4,meta1, meta2, meta3, meta4,meta1, meta2, meta3, meta4,
            meta1, meta2, meta3, meta4,meta1, meta2, meta3, meta4,meta1, meta2, meta3, meta4,meta1, meta2, meta3, meta4,
            meta1, meta2, meta3, meta4,meta1, meta2, meta3, meta4,meta1, meta2, meta3, meta4,meta1, meta2, meta3, meta4,
            meta1, meta2, meta3, meta4,meta1, meta2, meta3, meta4,meta1, meta2, meta3, meta4,meta1, meta2, meta3, meta4,
            meta1, meta2, meta3, meta4,meta1, meta2, meta3, meta4,meta1, meta2, meta3, meta4,meta1, meta2, meta3, meta4,
            meta1, meta2, meta3, meta4,meta1, meta2, meta3, meta4,meta1, meta2, meta3, meta4,meta1, meta2, meta3, meta4'
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->postJson('/api/admin/pages', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.meta', [
                'The meta must not be greater than 100 characters.'
            ]);
    }
}
