<?php

namespace Tests\Feature;

use App\Enums\DateFormat;
use App\Enums\DateTimeFormat;
use App\Models\Event;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

/**
 * Class EventManagementTest
 * @package Tests\Feature
 */
class EventManagementTest extends TestCase
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
    public function event_can_be_added()
    {
        $payload = [
            'title' => 'title',
            'thumbnail' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'image' => 'http://laracms.local/cms_assets/378-200x200.jpg',
            'event_at' => DateFormat::store('2021-01-19'),
            'teaser' => 'teaser',
            'detail' => 'detail',
            'publish_at' =>  DateTimeFormat::store('2021-01-20 23:59'),
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->postJson('/api/admin/events', $payload, $headers);

        $this->assertCount(1, Event::all());
        $response->assertCreated();
    }

    /** @test */
    public function event_can_be_updated()
    {
        $this->withoutExceptionHandling();

        $payload = [
            'title' => 'title',
            'thumbnail' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'image' => 'http://laracms.local/cms_assets/378-200x200.jpg',
            'event_at' => DateFormat::store('2021-01-19'),
            'teaser' => 'teaser',
            'detail' => 'detail',
            'publish_at' =>  DateTimeFormat::store('2021-01-20 23:59'),
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $this->postJson('/api/admin/events', $payload, $headers);

        $event = Event::first();

        $payload1 = [
            'title' => 'title1',
            'thumbnail' => 'http://laracms.local/cms_assets/25-200x300.jpg',
            'image' => 'http://laracms.local/cms_assets/29-200x200.jpg',
            'event_at' => DateFormat::store('2021-01-21'),
            'teaser' => 'teaser',
            'detail' => 'detail',
            'publish_at' =>  DateTimeFormat::store('2021-01-22 23:59'),
        ];

        $response = $this->patchJson("/api/admin/events/{$event->id}", $payload1, $headers);

        $event1 = Event::first();

        $this->assertEquals('http://laracms.local/cms_assets/25-200x300.jpg', $event1->thumbnail);
        $this->assertEquals('http://laracms.local/cms_assets/29-200x200.jpg', $event1->image);
        $this->assertEquals('detail', $event1->detail);
        $this->assertEquals('2021-01-22 23:59', $event1->publish_at);

        $response->assertOk();
    }

    /** @test */
    public function event_can_be_deleted()
    {
        $payload = [
            'title' => 'title',
            'thumbnail' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'image' => 'http://laracms.local/cms_assets/378-200x200.jpg',
            'event_at' => DateFormat::store('2021-01-19'),
            'teaser' => 'teaser',
            'detail' => 'detail',
            'publish_at' =>  DateTimeFormat::store('2021-01-20 23:59'),
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $this->postJson('/api/admin/events', $payload, $headers);

        $this->assertCount(1, Event::all());
        $event = Event::first();
        $response = $this->deleteJson("/api/admin/events/{$event->id}");
        $this->assertCount(0, Event::all());
        $response->assertOk();
    }

    /** @test */
    public function event_can_be_viewed()
    {
        $payload = [
            'title' => 'title',
            'thumbnail' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'image' => 'http://laracms.local/cms_assets/378-200x200.jpg',
            'event_at' => DateFormat::store('2021-01-19'),
            'teaser' => 'teaser',
            'detail' => 'detail',
            'publish_at' =>  DateTimeFormat::store('2021-01-20 23:59'),
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $this->postJson('/api/admin/events', $payload, $headers);

        $event = Event::first();
        $response = $this->getJson("/api/admin/events/{$event->id}");

        $this->assertEquals('http://laracms.local/cms_assets/1026-200x300.jpg', $event->thumbnail);
        $this->assertEquals('http://laracms.local/cms_assets/378-200x200.jpg', $event->image);
        $this->assertEquals('2021-01-19', $event->event_at);
        $this->assertEquals('detail', $event->detail);
        $this->assertEquals('2021-01-20 23:59', $event->publish_at);

        $response->assertOk();
    }

    /** @test */
    public function event_can_be_listed()
    {
        $this->postJson('/api/admin/events', [
            'title' => 'title',
            'thumbnail' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'image' => 'http://laracms.local/cms_assets/378-200x200.jpg',
            'event_at' => DateFormat::store('2021-01-19'),
            'teaser' => 'teaser',
            'detail' => 'detail',
            'publish_at' => DateTimeFormat::store('2021-01-20 23:59'),
        ]);

        $this->assertCount(1, Event::all());

        $payload = [
            'title' => 'title1',
            'thumbnail' => 'http://laracms.local/cms_assets/25-200x300.jpg',
            'image' => 'http://laracms.local/cms_assets/29-200x200.jpg',
            'event_at' => DateFormat::store('2021-01-21'),
            'teaser' => 'teaser',
            'detail' => 'detail',
            'publish_at' => DateTimeFormat::store('2021-01-22 23:00'),
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $this->postJson('/api/admin/events', $payload, $headers);

        $response = $this->getJson('/api/admin/events');

        $this->assertCount(2, Event::all());

        $response->assertOk();
    }

    public function event_publish_date_should_be_equal_or_greater_than_event_date()
    {
        $payload = [
            'title' => 'title',
            'thumbnail' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'image' => 'http://laracms.local/cms_assets/378-200x200.jpg',
            'event_at' => DateFormat::store('2021-01-20'),
            'teaser' => 'teaser',
            'detail' => 'detail',
            'publish_at' => DateTimeFormat::store('2021-01-19 23:59'),
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->postJson('/api/admin/events', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.publish_at', [
                'The publish at must be a date after or equal to event at.'
            ]);
    }

    public function event_event_date_should_be_equal_or_less_than_publish_date()
    {
        $payload = [
            'title' => 'title',
            'thumbnail' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'image' => 'http://laracms.local/cms_assets/378-200x200.jpg',
            'event_at' => DateFormat::store('2021-01-20'),
            'teaser' => 'teaser',
            'detail' => 'detail',
            'publish_at' => DateTimeFormat::store('2021-01-19 23:59'),
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->postJson('/api/admin/events', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.event_at', [
                'The event at must be a date before or equal to publish at.'
            ]);
    }

    /** @test */
    public function event_publish_date_should_have_specific_datetime_format_to_retrieve()
    {
        $payload = [
            'title' => 'title',
            'thumbnail' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'image' => 'http://laracms.local/cms_assets/378-200x200.jpg',
            'event_at' => DateFormat::store('2021-01-19'),
            'teaser' => 'teaser',
            'detail' => 'detail',
            'publish_at' => DateTimeFormat::store('2021-01-20 23:59'),
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->postJson('/api/admin/events', $payload, $headers);

        $event = Event::first();

        $this->assertEquals('2021-01-20 23:59', $event->publish_at);

        $response->assertCreated();
    }

    /** @test */
    public function event_event_date_should_have_specific_date_format_to_retrieve()
    {
        $payload = [
            'title' => 'title',
            'thumbnail' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'image' => 'http://laracms.local/cms_assets/378-200x200.jpg',
            'event_at' => DateFormat::store('2021-01-19'),
            'teaser' => 'teaser',
            'detail' => 'detail',
            'publish_at' =>  DateTimeFormat::store('2021-01-20 23:59'),
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->postJson('/api/admin/events', $payload, $headers);

        $event = Event::first();

        $this->assertEquals('2021-01-19', $event->event_at);

        $response->assertCreated();
    }

    /** @test */
    public function event_event_date_should_have_specific_date_format_to_save()
    {
        $payload = [
            'title' => 'title',
            'thumbnail' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'image' => 'http://laracms.local/cms_assets/378-200x200.jpg',
            'event_at' => '19-01-2021',
            'teaser' => 'teaser',
            'detail' => 'detail',
            'publish_at' =>  DateTimeFormat::store('2021-01-20 23:59'),
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->postJson('/api/admin/events', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.event_at', [
                'The event at does not match the format Y-m-d.'
            ]);
    }

    /** @test */
    public function event_publish_date_should_have_specific_datetime_format_to_save()
    {
        $payload = [
            'title' => 'title',
            'thumbnail' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'image' => 'http://laracms.local/cms_assets/378-200x200.jpg',
            'event_at' => DateFormat::store('2021-01-19'),
            'teaser' => 'teaser',
            'detail' => 'detail',
            'publish_at' =>  '20-01-2021 23:59',
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->postJson('/api/admin/events', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.publish_at', [
                'The publish at does not match the format Y-m-d H:i.'
            ]);
    }

    /** @test */
    public function event_event_is_required()
    {
        $payload = [
            'title' => '',
            'thumbnail' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'image' => 'http://laracms.local/cms_assets/378-200x200.jpg',
            'event_at' => DateFormat::store('2021-01-19'),
            'teaser' => 'teaser',
            'detail' => 'detail',
            'publish_at' =>  DateTimeFormat::store('2021-01-20 23:59'),
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->postJson('/api/admin/events', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.title', [
                'The title field is required.'
            ]);
    }

    /** @test */
    public function event_event_should_have_minimum_length()
    {
        $payload = [
            'title' => 't',
            'thumbnail' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'image' => 'http://laracms.local/cms_assets/378-200x200.jpg',
            'event_at' => DateFormat::store('2021-01-19'),
            'teaser' => 'teaser',
            'detail' => 'detail',
            'publish_at' =>  DateTimeFormat::store('2021-01-20 23:59'),
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->postJson('/api/admin/events', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.title', [
                'The title must be at least 3 characters.'
            ]);
    }

    /** @test */
    public function event_event_should_have_maximum_length()
    {
        $payload = [
            'title' => 'titletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitle
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
            titletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitle
            titletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitle
            titletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitletitle',
            'thumbnail' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'image' => 'http://laracms.local/cms_assets/378-200x200.jpg',
            'event_at' => DateFormat::store('2021-01-19'),
            'teaser' => 'teaser',
            'detail' => 'detail',
            'publish_at' =>  DateTimeFormat::store('2021-01-20 23:59'),
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->postJson('/api/admin/events', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.title', [
                'The title must not be greater than 100 characters.'
            ]);
    }

    /** @test */
    public function event_thumbnail_is_required()
    {
        $payload = [
            'title' => 'title',
            'thumbnail' => '',
            'image' => 'http://laracms.local/cms_assets/378-200x200.jpg',
            'event_at' => DateFormat::store('2021-01-19'),
            'teaser' => 'teaser',
            'detail' => 'detail',
            'publish_at' =>  DateTimeFormat::store('2021-01-20 23:59'),
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->postJson('/api/admin/events', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.thumbnail', [
                'The thumbnail field is required.'
            ]);
    }

    /** @test */
    public function event_thumbnail_should_have_correct_url_format()
    {
        $payload = [
            'title' => 'title',
            'thumbnail' => 'email@example1.com',
            'image' => 'http://laracms.local/cms_assets/378-200x200.jpg',
            'event_at' => DateFormat::store('2021-01-19'),
            'teaser' => 'teaser',
            'detail' => 'detail',
            'publish_at' => DateTimeFormat::store('2021-01-20 23:59'),
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->postJson('/api/admin/events', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.thumbnail', [
                'The thumbnail must be a valid URL.'
            ]);
    }

    /** @test */
    public function event_thumbnail_should_have_minimum_length()
    {
        $payload = [
            'title' => 'title',
            'thumbnail' => 'http://www.l',
            'image' => 'http://laracms.local/cms_assets/378-200x200.jpg',
            'event_at' => DateFormat::store('2021-01-19'),
            'teaser' => 'teaser',
            'detail' => 'detail',
            'publish_at' => DateTimeFormat::store('2021-01-20 23:59'),
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->postJson('/api/admin/events', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.thumbnail', [
                'The thumbnail must be at least 14 characters.'
            ]);
    }

    /** @test */
    public function event_thumbnail_should_have_maximum_length()
    {
        $payload = [
            'title' => 'title',
            'thumbnail' => 'http://laracms.local/cms_assets/1026-200x3001026-200x3001026-200x3001026-200x3001026-200x300
            1026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x300
            1026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x300
            1026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x300
            1026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x300
            1026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x300
            1026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x300.jpg',
            'image' => 'http://laracms.local/cms_assets/378-200x200.jpg',
            'event_at' => DateFormat::store('2021-01-19'),
            'teaser' => 'teaser',
            'detail' => 'detail',
            'publish_at' => DateTimeFormat::store('2021-01-20 23:59'),
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->postJson('/api/admin/events', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.thumbnail', [
                'The thumbnail must be a valid URL.',
                'The thumbnail must not be greater than 191 characters.'
            ]);
    }

    /** @test */
    public function event_image_is_required()
    {
        $payload = [
            'title' => 'title',
            'thumbnail' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'image' => '',
            'event_at' => DateFormat::store('2021-01-19'),
            'teaser' => 'teaser',
            'detail' => 'detail',
            'publish_at' =>  DateTimeFormat::store('2021-01-20 23:59'),
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->postJson('/api/admin/events', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.image', [
                'The image field is required.'
            ]);
    }

    /** @test */
    public function event_image_should_have_correct_url_format()
    {
        $payload = [
            'title' => 'title',
            'thumbnail' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'image' => 'email@example1.com',
            'event_at' => DateFormat::store('2021-01-19'),
            'teaser' => 'teaser',
            'detail' => 'detail',
            'publish_at' => DateTimeFormat::store('2021-01-20 23:59'),
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
    public function event_image_should_have_minimum_length()
    {
        $payload = [
            'title' => 'title',
            'thumbnail' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'image' => 'http://www.l',
            'event_at' => DateFormat::store('2021-01-19'),
            'teaser' => 'teaser',
            'detail' => 'detail',
            'publish_at' => DateTimeFormat::store('2021-01-20 23:59'),
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
    public function event_image_should_have_maximum_length()
    {
        $payload = [
            'title' => 'title',
            'thumbnail' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'image' => 'http://laracms.local/cms_assets/378-200x200378-200x200378-200x200378-200x200378-200x200
            378-200x200378-200x200378-200x200378-200x200378-200x200378-200x200378-200x200378-200x200378-200x200
            378-200x200378-200x200378-200x200378-200x200378-200x200378-200x200378-200x200378-200x200378-200x200
            378-200x200378-200x200378-200x200378-200x200378-200x200378-200x200378-200x200378-200x200378-200x200
            378-200x200378-200x200378-200x200378-200x200378-200x200378-200x200378-200x200378-200x200378-200x200
            378-200x200378-200x200378-200x200378-200x200378-200x200378-200x200378-200x200378-200x200378-200x200
            378-200x200378-200x200378-200x200378-200x200378-200x200378-200x200378-200x200378-200x200378-200x200.jpg',
            'event_at' => DateFormat::store('2021-01-19'),
            'teaser' => 'teaser',
            'detail' => 'detail',
            'publish_at' => DateTimeFormat::store('2021-01-20 23:59'),
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
    public function event_teaser_is_required()
    {
        $payload = [
            'title' => 'title',
            'thumbnail' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'image' => 'http://laracms.local/cms_assets/378-200x200.jpg',
            'event_at' => DateFormat::store('2021-01-19'),
            'teaser' => '',
            'detail' => 'detail',
            'publish_at' =>  DateTimeFormat::store('2021-01-20 23:59'),
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->postJson('/api/admin/events', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.teaser', [
                'The teaser field is required.'
            ]);
    }

    /** @test */
    public function event_teaser_should_have_minimum_length()
    {
        $payload = [
            'title' => 'title',
            'thumbnail' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'image' => 'http://laracms.local/cms_assets/378-200x200.jpg',
            'event_at' => DateFormat::store('2021-01-19'),
            'teaser' => 't',
            'detail' => 'detail',
            'publish_at' =>  DateTimeFormat::store('2021-01-20 23:59'),
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->postJson('/api/admin/events', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.teaser', [
                'The teaser must be at least 3 characters.'
            ]);
    }

    /** @test */
    public function event_teaser_should_have_maximum_length()
    {
        $payload = [
            'title' => 'title',
            'thumbnail' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'image' => 'http://laracms.local/cms_assets/378-200x200.jpg',
            'event_at' => DateFormat::store('2021-01-19'),
            'teaser' => 'teaserteaserteaserteaserteaserteaserteaserteaserteaserteaserteaserteaserteaserteaserteaser
            teaserteaserteaserteaserteaserteaserteaserteaserteaserteaserteaserteaserteaserteaserteaserteaserteaserteaser
            teaserteaserteaserteaserteaserteaserteaserteaserteaserteaserteaserteaserteaserteaserteaserteaserteaserteaser
            teaserteaserteaserteaserteaserteaserteaserteaserteaserteaserteaserteaserteaserteaserteaserteaserteaserteaser
            teaserteaserteaserteaserteaserteaserteaserteaserteaserteaserteaserteaserteaserteaserteaserteaserteaserteaser
            teaserteaserteaserteaserteaserteaserteaserteaserteaserteaserteaserteaserteaserteaserteaserteaserteaserteaser
            teaserteaserteaserteaserteaserteaserteaserteaserteaserteaserteaserteaserteaserteaserteaserteaserteaserteaser
            teaserteaserteaserteaserteaserteaserteaserteaserteaserteaserteaserteaserteaserteaserteaserteaserteaserteaser
            teaserteaserteaserteaserteaserteaserteaserteaserteaserteaserteaserteaserteaserteaserteaserteaserteaserteaser
            teaserteaserteaserteaserteaserteaserteaserteaserteaserteaserteaserteaserteaserteaserteaserteaserteaserteaser
            teaserteaserteaserteaserteaserteaserteaserteaserteaserteaserteaserteaserteaserteaserteaserteaserteaserteaser
            teaserteaserteaserteaserteaserteaserteaserteaserteaserteaserteaserteaserteaserteaserteaserteaserteaserteaser
            teaserteaserteaserteaserteaserteaserteaserteaserteaserteaserteaserteaserteaserteaserteaserteaserteaserteaser
            teaserteaserteaserteaserteaserteaserteaserteaserteaserteaserteaserteaserteaserteaserteaserteaserteaserteaser
            teaserteaserteaserteaserteaserteaserteaserteaserteaserteaserteaserteaserteaserteaserteaserteaserteaserteaser
            teaserteaserteaserteaserteaserteaserteaserteaserteaserteaserteaserteaserteaserteaserteaserteaserteaserteaser
            teaserteaserteaserteaserteaserteaserteaserteaserteaserteaserteaserteaserteaserteaserteaserteaserteaserteaser
            teaserteaserteaserteaserteaserteaserteaserteaserteaserteaserteaserteaserteaserteaserteaserteaserteaserteaser
            teaserteaserteaserteaserteaserteaserteaserteaserteaserteaserteaserteaserteaserteaserteaserteaserteaserteaser
            teaserteaserteaserteaserteaserteaserteaserteaserteaserteaserteaserteaserteaserteaserteaserteaserteaserteaser',
            'detail' => 'detail',
            'publish_at' =>  DateTimeFormat::store('2021-01-20 23:59'),
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->postJson('/api/admin/events', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.teaser', [
                'The teaser must not be greater than 500 characters.'
            ]);
    }

    /** @test */
    public function event_detail_is_required()
    {
        $payload = [
            'title' => 'title',
            'thumbnail' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'image' => 'http://laracms.local/cms_assets/378-200x200.jpg',
            'event_at' => DateFormat::store('2021-01-19'),
            'teaser' => 'teaser',
            'detail' => '',
            'publish_at' =>  DateTimeFormat::store('2021-01-20 23:59'),
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->postJson('/api/admin/events', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.detail', [
                'The detail field is required.'
            ]);
    }

    /** @test */
    public function event_detail_should_have_minimum_length()
    {
        $payload = [
            'title' => 'title',
            'thumbnail' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'image' => 'http://laracms.local/cms_assets/378-200x200.jpg',
            'event_at' => DateFormat::store('2021-01-19'),
            'teaser' => 'teaser',
            'detail' => 'd',
            'publish_at' =>  DateTimeFormat::store('2021-01-20 23:59'),
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->postJson('/api/admin/events', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.detail', [
                'The detail must be at least 3 characters.'
            ]);
    }

    public function event_detail_should_have_maximum_length()
    {
        $payload = [
            'title' => 'title',
            'thumbnail' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'image' => 'http://laracms.local/cms_assets/378-200x200.jpg',
            'event_at' => DateFormat::store('2021-01-19'),
            'teaser' => 'teaser',
            'detail' => 'detaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetail
            detaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetail
            detaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetail
            detaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetail
            detaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetail
            detaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetail
            detaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetail
            detaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetail
            detaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetail
            detaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetail
            detaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetail
            detaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetail
            detaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetail
            detaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetail
            detaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetail
            detaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetail
            detaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetail
            detaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetail
            detaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetail
            detaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetail
            detaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetail
            detaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetail
            detaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetail
            detaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetail
            detaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetail
            detaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetail
            detaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetail
            detaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetail
            detaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetail
            detaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetail
            detaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetail
            detaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetail
            detaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetail
            detaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetail
            detaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetail
            detaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetail
            detaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetail
            detaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetail
            detaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetail
            detaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetail
            detaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetail
            detaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetail
            detaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetail
            detaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetail
            detaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetail
            detaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetail
            detaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetail
            detaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetail
            detaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetail
            detaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetail
            detaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetail
            detaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetail
            detaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetail
            detaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetail
            detaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetail
            detaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetail
            detaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetail
            detaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetail
            detaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetail
            detaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetail
            detaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetaildetail',
            'publish_at' =>  DateTimeFormat::store('2021-01-20 23:59'),
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->postJson('/api/admin/events', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.detail', [
                'The detail must not be greater than 2000 characters.'
            ]);
    }
}
