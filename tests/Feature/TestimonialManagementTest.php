<?php

namespace Tests\Feature;

use App\Models\Testimonial;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class TestimonialManagementTest extends TestCase
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
    public function testtestimonial_can_be_added()
    {
        $payload = [
            'photo' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'client_name' => 'client_name',
            'person_name' => 'person_name',
            'designation' => 'designation',
            'message' => 'message',
            'order' => 1
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->post('/api/admin/testimonials', $payload, $headers);

        $this->assertCount(1, Testimonial::all());
        $response->assertCreated();
    }

    /** @test */
    public function testtestimonial_can_be_updated()
    {
        $payload = [
            'photo' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'client_name' => 'client_name',
            'person_name' => 'person_name',
            'designation' => 'designation',
            'message' => 'message',
            'order' => 1
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $this->post('/api/admin/testimonials', $payload, $headers);

        $testimonial = Testimonial::first();

        $payload = [
            'photo' => 'http://laracms.local/cms_assets/25-200x300.jpg',
            'client_name' => 'client_name1',
            'person_name' => 'person_name1',
            'designation' => 'designation1',
            'message' => 'message1',
            'order' => 2
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->patch("/api/admin/testimonials/{$testimonial->id}", $payload, $headers);

        $testimonial1 = Testimonial::first();

        $this->assertEquals('http://laracms.local/cms_assets/25-200x300.jpg', $testimonial1->photo);
        $this->assertEquals('client_name1', $testimonial1->client_name);
        $this->assertEquals('person_name1', $testimonial1->person_name);
        $this->assertEquals('designation1', $testimonial1->designation);
        $this->assertEquals('message1', $testimonial1->message);
        $this->assertEquals(2, $testimonial1->order);

        $response->assertOk();
    }

    /** @test */
    public function testtestimonial_can_be_deleted()
    {
        $payload = [
            'photo' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'client_name' => 'client_name',
            'person_name' => 'person_name',
            'designation' => 'designation',
            'message' => 'message',
            'order' => 1
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $this->post('/api/admin/testimonials', $payload, $headers);

        $this->assertCount(1, Testimonial::all());

        $testimonial = Testimonial::first();
        $response = $this->delete("/api/admin/testimonials/{$testimonial->id}");

        $this->assertCount(0, Testimonial::all());

        $response->assertOk();
    }

    /** @test */
    public function testtestimonial_can_be_viewed()
    {
        $payload = [
            'photo' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'client_name' => 'client_name',
            'person_name' => 'person_name',
            'designation' => 'designation',
            'message' => 'message',
            'order' => 1
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $this->post('/api/admin/testimonials', $payload, $headers);

        $testimonial = Testimonial::first();
        $response = $this->get("/api/admin/testimonials/{$testimonial->id}");

        $this->assertEquals('http://laracms.local/cms_assets/1026-200x300.jpg', $testimonial->photo);
        $this->assertEquals('client_name', $testimonial->client_name);
        $this->assertEquals('person_name', $testimonial->person_name);
        $this->assertEquals('designation', $testimonial->designation);
        $this->assertEquals('message', $testimonial->message);
        $this->assertEquals(1, $testimonial->order);

        $response->assertOk();
    }

    /** @test */
    public function testtestimonial_can_be_listed()
    {
        $payload = [
            'photo' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'client_name' => 'client_name',
            'person_name' => 'person_name',
            'designation' => 'designation',
            'message' => 'message',
            'order' => 1
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $this->post('/api/admin/testimonials', $payload, $headers);

        $this->assertCount(1, Testimonial::all());

        $payload = [
            'photo' => 'http://laracms.local/cms_assets/25-200x300.jpg',
            'client_name' => 'client_name1',
            'person_name' => 'person_name1',
            'designation' => 'designation1',
            'message' => 'message1',
            'order' => 2
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $this->post('/api/admin/testimonials', $payload, $headers);

        $this->assertCount(2, Testimonial::all());

        $response = $this->get('/api/admin/testimonials');

        $response->assertOk();
    }

    /** @test */
    public function testtestimonial_photo_is_required()
    {
        $payload = [
            'photo' => '',
            'client_name' => 'client_name',
            'person_name' => 'person_name',
            'designation' => 'designation',
            'message' => 'message',
            'order' => 1
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->post('/api/admin/testimonials', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.photo', [
                'The photo field is required.'
            ]);
    }

    /** @test */
    public function testtestimonial_photo_should_have_correct_url_format()
    {
        $payload = [
            'photo' => 'email@example1.com',
            'client_name' => 'client_name',
            'person_name' => 'person_name',
            'designation' => 'designation',
            'message' => 'message',
            'order' => 1
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->postJson('/api/admin/testimonials', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.photo', [
                'The photo must be a valid URL.'
            ]);
    }

    /** @test */
    public function testtestimonial_photo_should_have_minimum_length()
    {
        $payload = [
            'photo' => 'http://www.l',
            'client_name' => 'client_name',
            'person_name' => 'person_name',
            'designation' => 'designation',
            'message' => 'message',
            'order' => 1
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->postJson('/api/admin/testimonials', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.photo', [
                'The photo must be at least 14 characters.'
            ]);
    }

    /** @test */
    public function testtestimonial_photo_should_have_maximum_length()
    {
        $payload = [
            'photo' => 'http://laracms.local/cms_assets/1026-200x3001026-200x3001026-200x3001026-200x3001026-200x300
            1026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x300
            1026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x300
            1026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x300
            1026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x300
            1026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x300
            1026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x300
            1026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x300
            1026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x300.jpg',
            'client_name' => 'client_name',
            'person_name' => 'person_name',
            'designation' => 'designation',
            'message' => 'message',
            'order' => 1
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->postJson('/api/admin/testimonials', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.photo', [
                'The photo must be a valid URL.',
                'The photo must not be greater than 191 characters.'
            ]);
    }

    /** @test */
    public function testtestimonial_client_name_is_required()
    {
        $payload = [
            'photo' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'client_name' => '',
            'person_name' => 'person_name',
            'designation' => 'designation',
            'message' => 'message',
            'order' => 1
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->post('/api/admin/testimonials', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.client_name', [
                'The client name field is required.'
            ]);
    }

    /** @test */
    public function testtestimonial_client_name_should_have_minimum_length()
    {
        $payload = [
            'photo' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'client_name' => 'c',
            'person_name' => 'person_name',
            'designation' => 'designation',
            'message' => 'message',
            'order' => 1
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->post('/api/admin/testimonials', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.client_name', [
                'The client name must be at least 3 characters.'
            ]);
    }

    /** @test */
    public function testtestimonial_client_name_should_have_maximum_length()
    {
        $payload = [
            'photo' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'client_name' => 'client_nameclient_nameclient_nameclient_nameclient_nameclient_nameclient_nameclient_name
            client_nameclient_nameclient_nameclient_nameclient_nameclient_nameclient_nameclient_nameclient_name
            client_nameclient_nameclient_nameclient_nameclient_nameclient_nameclient_nameclient_nameclient_name
            client_nameclient_nameclient_nameclient_nameclient_nameclient_nameclient_nameclient_nameclient_name
            client_nameclient_nameclient_nameclient_nameclient_nameclient_nameclient_nameclient_nameclient_name
            client_nameclient_nameclient_nameclient_nameclient_nameclient_nameclient_nameclient_nameclient_name
            client_nameclient_nameclient_nameclient_nameclient_nameclient_nameclient_nameclient_nameclient_name
            client_nameclient_nameclient_nameclient_nameclient_nameclient_nameclient_nameclient_nameclient_name
            client_nameclient_nameclient_nameclient_nameclient_nameclient_nameclient_nameclient_nameclient_name
            client_nameclient_nameclient_nameclient_nameclient_nameclient_nameclient_nameclient_nameclient_name',
            'person_name' => 'person_name',
            'designation' => 'designation',
            'message' => 'message',
            'order' => 1
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->post('/api/admin/testimonials', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.client_name', [
                'The client name must not be greater than 100 characters.'
            ]);
    }

    /** @test */
    public function testtestimonial_person_name_should_have_minimum_length()
    {
        $payload = [
            'photo' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'client_name' => 'client_name',
            'person_name' => 'p',
            'designation' => 'designation',
            'message' => 'message',
            'order' => 1
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->post('/api/admin/testimonials', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.person_name', [
                'The person name must be at least 3 characters.'
            ]);
    }

    /** @test */
    public function testtestimonial_person_name_should_have_maximum_length()
    {
        $payload = [
            'photo' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'client_name' => 'client_name',
            'person_name' => 'person_nameperson_nameperson_nameperson_nameperson_nameperson_nameperson_nameperson_name
            person_nameperson_nameperson_nameperson_nameperson_nameperson_nameperson_nameperson_nameperson_name
            person_nameperson_nameperson_nameperson_nameperson_nameperson_nameperson_nameperson_nameperson_name
            person_nameperson_nameperson_nameperson_nameperson_nameperson_nameperson_nameperson_nameperson_name
            person_nameperson_nameperson_nameperson_nameperson_nameperson_nameperson_nameperson_nameperson_name
            person_nameperson_nameperson_nameperson_nameperson_nameperson_nameperson_nameperson_nameperson_name
            person_nameperson_nameperson_nameperson_nameperson_nameperson_nameperson_nameperson_nameperson_name
            person_nameperson_nameperson_nameperson_nameperson_nameperson_nameperson_nameperson_nameperson_name
            person_nameperson_nameperson_nameperson_nameperson_nameperson_nameperson_nameperson_nameperson_name',
            'designation' => 'designation',
            'message' => 'message',
            'order' => 1
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->post('/api/admin/testimonials', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.person_name', [
                'The person name must not be greater than 100 characters.'
            ]);
    }

    /** @test */
    public function testtestimonial_designation_should_have_minimum_length()
    {
        $payload = [
            'photo' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'client_name' => 'client_name',
            'person_name' => 'person_name',
            'designation' => 'd',
            'message' => 'message',
            'order' => 1
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->post('/api/admin/testimonials', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.designation', [
                'The designation must be at least 3 characters.'
            ]);
    }

    /** @test */
    public function testtestimonial_designation_should_have_maximum_length()
    {
        $payload = [
            'photo' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'client_name' => 'client_name',
            'person_name' => 'person_name',
            'designation' => 'designationdesignationdesignationdesignationdesignationdesignationdesignationdesignation
            designationdesignationdesignationdesignationdesignationdesignationdesignationdesignationdesignation
            designationdesignationdesignationdesignationdesignationdesignationdesignationdesignationdesignation
            designationdesignationdesignationdesignationdesignationdesignationdesignationdesignationdesignation
            designationdesignationdesignationdesignationdesignationdesignationdesignationdesignationdesignation
            designationdesignationdesignationdesignationdesignationdesignationdesignationdesignationdesignation
            designationdesignationdesignationdesignationdesignationdesignationdesignationdesignationdesignation
            designationdesignationdesignationdesignationdesignationdesignationdesignationdesignationdesignation
            designationdesignationdesignationdesignationdesignationdesignationdesignationdesignationdesignation',
            'message' => 'message',
            'order' => 1
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->post('/api/admin/testimonials', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.designation', [
                'The designation must not be greater than 100 characters.'
            ]);
    }

    /** @test */
    public function testtestimonial_message_is_required()
    {
        $payload = [
            'photo' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'client_name' => '',
            'person_name' => 'person_name',
            'designation' => 'designation',
            'message' => '',
            'order' => 1
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->post('/api/admin/testimonials', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.message', [
                'The message field is required.'
            ]);
    }

    /** @test */
    public function testtestimonial_message_should_have_minimum_length()
    {
        $payload = [
            'photo' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'client_name' => 'c',
            'person_name' => 'person_name',
            'designation' => 'designation',
            'message' => 'm',
            'order' => 1
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->post('/api/admin/testimonials', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.message', [
                'The message must be at least 3 characters.'
            ]);
    }

    /** @test */
    public function testtestimonial_message_should_have_maximum_length()
    {
        $payload = [
            'photo' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'client_name' => 'client_name',
            'person_name' => 'person_name',
            'designation' => 'designation',
            'message' => 'messagemessagemessagemessagemessagemessagemessagemessagemessagemessagemessagemessagemessage
            messagemessagemessagemessagemessagemessagemessagemessagemessagemessagemessagemessagemessagemessagemessage
            messagemessagemessagemessagemessagemessagemessagemessagemessagemessagemessagemessagemessagemessagemessage
            messagemessagemessagemessagemessagemessagemessagemessagemessagemessagemessagemessagemessagemessagemessage
            messagemessagemessagemessagemessagemessagemessagemessagemessagemessagemessagemessagemessagemessagemessage
            messagemessagemessagemessagemessagemessagemessagemessagemessagemessagemessagemessagemessagemessagemessage
            messagemessagemessagemessagemessagemessagemessagemessagemessagemessagemessagemessagemessagemessagemessage
            messagemessagemessagemessagemessagemessagemessagemessagemessagemessagemessagemessagemessagemessagemessage
            messagemessagemessagemessagemessagemessagemessagemessagemessagemessagemessagemessagemessagemessagemessage
            messagemessagemessagemessagemessagemessagemessagemessagemessagemessagemessagemessagemessagemessagemessage
            messagemessagemessagemessagemessagemessagemessagemessagemessagemessagemessagemessagemessagemessagemessage
            messagemessagemessagemessagemessagemessagemessagemessagemessagemessagemessagemessagemessagemessagemessage
            messagemessagemessagemessagemessagemessagemessagemessagemessagemessagemessagemessagemessagemessagemessage',
            'order' => 1
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->post('/api/admin/testimonials', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.message', [
                'The message must not be greater than 1000 characters.'
            ]);
    }

    /** @test */
    public function testtestimonial_order_is_required()
    {
        $payload = [
            'photo' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'client_name' => 'client_name',
            'person_name' => 'person_name',
            'designation' => 'designation',
            'message' => 'message',
            'order' => null
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->post('/api/admin/testimonials', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.order', [
                'The order field is required.'
            ]);
    }

    /** @test */
    public function testtestimonial_order_should_be_integer_type()
    {
        $payload = [
            'photo' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'client_name' => 'client_name',
            'person_name' => 'person_name',
            'designation' => 'designation',
            'message' => 'message',
            'order' => 'a'
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->post('/api/admin/testimonials', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.order', [
                'The order must be an integer.'
            ]);
    }
}
