<?php

namespace Tests\Feature;

use App\Models\Management;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

/**
 * Class ManagementTest
 * @package Tests\Feature
 */
class ManagementTest extends TestCase
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
    public function management_can_be_added()
    {
        $payload = [
            'photo' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'person_name' => 'person_name',
            'designation' => 'designation',
            'message' => 'message',
            'url' => 'http://www.example.com',
            'order' => 1,
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->postJson('/api/admin/managements', $payload, $headers);

        $this->assertCount(1, Management::all());
        $response->assertCreated();
    }

    /** @test */
    public function management_can_be_updated()
    {
        $payload = [
            'photo' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'person_name' => 'person_name',
            'designation' => 'designation',
            'message' => 'message',
            'url' => 'http://www.example.com',
            'order' => 1,
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $this->postJson('/api/admin/managements', $payload, $headers);

        $management = Management::first();

        $payload1 = [
            'photo' => 'http://laracms.local/cms_assets/25-200x300.jpg',
            'person_name' => 'person_name1',
            'designation' => 'designation1',
            'message' => 'message1',
            'url' => 'http://www.example1.com',
            'order' => 2,
        ];

        $response = $this->patchJson("/api/admin/managements/{$management->id}", $payload1, $headers);

        $management1 = Management::first();

        $this->assertEquals('http://laracms.local/cms_assets/25-200x300.jpg', $management1->photo);
        $this->assertEquals('person_name1', $management1->person_name);
        $this->assertEquals('designation1', $management1->designation);
        $this->assertEquals('message1', $management1->message);
        $this->assertEquals(2, $management1->order);

        $response->assertOk();
    }

    /** @test */
    public function management_can_be_deleted()
    {
        $payload = [
            'photo' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'person_name' => 'person_name',
            'designation' => 'designation',
            'message' => 'message',
            'url' => 'http://www.example.com',
            'order' => 1,
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $this->postJson('/api/admin/managements', $payload, $headers);

        $this->assertCount(1, Management::all());
        $management = Management::first();
        $response = $this->deleteJson("/api/admin/managements/{$management->id}");
        $this->assertCount(0, Management::all());

        $response->assertOk();
    }

    /** @test */
    public function management_can_be_viewed()
    {
        $payload = [
            'photo' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'person_name' => 'person_name',
            'designation' => 'designation',
            'message' => 'message',
            'url' => 'http://www.example.com',
            'order' => 1,
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $this->postJson('/api/admin/managements', $payload, $headers);

        $management = Management::first();
        $response = $this->getJson("/api/admin/managements/{$management->id}");

        $this->assertEquals('http://laracms.local/cms_assets/1026-200x300.jpg', $management->photo);
        $this->assertEquals('person_name', $management->person_name);
        $this->assertEquals('designation', $management->designation);
        $this->assertEquals('message', $management->message);
        $this->assertEquals(1, $management->order);

        $response->assertOk();
    }

    /** @test */
    public function management_can_be_listed()
    {
        $payload = [
            'photo' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'person_name' => 'person_name',
            'designation' => 'designation',
            'message' => 'message',
            'url' => 'http://www.example.com',
            'order' => 1,
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $this->postJson('/api/admin/managements', $payload, $headers);

        $payload1 = [
            'photo' => 'http://laracms.local/cms_assets/25-200x300.jpg',
            'person_name' => 'person_name1',
            'designation' => 'designation1',
            'message' => 'message1',
            'url' => 'http://www.example1.com',
            'order' => 2,
        ];


        $this->postJson('/api/admin/managements', $payload1, $headers);

        $response = $this->getJson('/api/admin/managements');

        $response->assertOk();
    }

    /** @test */
    public function management_photo_is_required()
    {
        $payload = [
            'photo' => '',
            'person_name' => 'person_name',
            'designation' => 'designation',
            'message' => 'message',
            'url' => 'http://www.example.com',
            'order' => 1,
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->postJson('/api/admin/managements', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.photo', [
                'The photo field is required.'
            ]);
    }


    /** @test */
    public function management_photo_should_have_correct_url_format()
    {
        $payload = [
            'photo' => 'email@exmple.com',
            'person_name' => 'person_name',
            'designation' => 'designation',
            'message' => 'message',
            'url' => 'http://www.example.com',
            'order' => 1,
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->postJson('/api/admin/managements', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.photo', [
                'The photo must be a valid URL.'
            ]);
    }

    /** @test */
    public function management_photo_should_have_minimum_length()
    {
        $payload = [
            'photo' => 'http://www.l',
            'person_name' => 'person_name',
            'designation' => 'designation',
            'message' => 'message',
            'url' => 'http://www.example.com',
            'order' => 1,
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->postJson('/api/admin/managements', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.photo', [
                'The photo must be at least 14 characters.'
            ]);
    }

    /** @test */
    public function management_photo_should_have_maximum_length()
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
            1026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x300
            1026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x3001026-200x300.jpg',
            'person_name' => 'person_name',
            'designation' => 'designation',
            'message' => 'message',
            'url' => 'http://www.example.com',
            'order' => 1,
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->postJson('/api/admin/managements', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.photo', [
                'The photo must be a valid URL.',
                'The photo must not be greater than 191 characters.'
            ]);
    }

    /** @test */
    public function management_person_name_is_required()
    {
        $payload = [
            'photo' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'person_name' => '',
            'designation' => 'designation',
            'message' => 'message',
            'url' => 'http://www.example.com',
            'order' => 1,
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->postJson('/api/admin/managements', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.person_name', [
                'The person name field is required.'
            ]);
    }

    /** @test */
    public function management_person_name_should_have_minimum_length()
    {
        $payload = [
            'photo' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'person_name' => 'p',
            'designation' => 'designation',
            'message' => 'message',
            'url' => 'http://www.example.com',
            'order' => 1,
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->postJson('/api/admin/managements', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.person_name', [
                'The person name must be at least 3 characters.'
            ]);
    }

    /** @test */
    public function management_person_name_should_have_maximum_length()
    {
        $payload = [
            'photo' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'person_name' => 'person_nameperson_nameperson_nameperson_nameperson_nameperson_nameperson_nameperson_name
            person_nameperson_nameperson_nameperson_nameperson_nameperson_nameperson_nameperson_nameperson_name
            person_nameperson_nameperson_nameperson_nameperson_nameperson_nameperson_nameperson_nameperson_name
            person_nameperson_nameperson_nameperson_nameperson_nameperson_nameperson_nameperson_nameperson_name
            person_nameperson_nameperson_nameperson_nameperson_nameperson_nameperson_nameperson_nameperson_name',
            'designation' => 'designation',
            'message' => 'message',
            'url' => 'http://www.example.com',
            'order' => 1,
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->postJson('/api/admin/managements', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.person_name', [
                'The person name must not be greater than 100 characters.'
            ]);
    }

    /** @test */
    public function management_designation_is_required()
    {
        $payload = [
            'photo' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'person_name' => 'person_name',
            'designation' => '',
            'message' => 'message',
            'url' => 'http://www.example.com',
            'order' => 1,
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->postJson('/api/admin/managements', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.designation', [
                'The designation field is required.'
            ]);
    }

    /** @test */
    public function management_designation_should_have_minimum_length()
    {
        $payload = [
            'photo' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'person_name' => 'person_name',
            'designation' => 'd',
            'message' => 'message',
            'url' => 'http://www.example.com',
            'order' => 1,
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->postJson('/api/admin/managements', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.designation', [
                'The designation must be at least 3 characters.'
            ]);
    }

    /** @test */
    public function management_designation_should_have_maximum_length()
    {
        $payload = [
            'photo' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'person_name' => 'person_name',
            'designation' => 'designationdesignationdesignationdesignationdesignationdesignationdesignationdesignation
            designationdesignationdesignationdesignationdesignationdesignationdesignationdesignationdesignation
            designationdesignationdesignationdesignationdesignationdesignationdesignationdesignationdesignation
            designationdesignationdesignationdesignationdesignationdesignationdesignationdesignationdesignation
            designationdesignationdesignationdesignationdesignationdesignationdesignationdesignationdesignation
            designationdesignationdesignationdesignationdesignationdesignationdesignationdesignationdesignation
            designationdesignationdesignationdesignationdesignationdesignationdesignationdesignationdesignation',
            'message' => 'message',
            'url' => 'http://www.example.com',
            'order' => 1,
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->postJson('/api/admin/managements', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.designation', [
                'The designation must not be greater than 100 characters.'
            ]);
    }

    /** @test */
    public function management_message_is_required()
    {
        $payload = [
            'photo' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'person_name' => 'person_name',
            'designation' => 'designation',
            'message' => '',
            'url' => 'http://www.example.com',
            'order' => 1,
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->postJson('/api/admin/managements', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.message', [
                'The message field is required.'
            ]);
    }

    /** @test */
    public function management_message_should_have_minimum_length()
    {
        $payload = [
            'photo' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'person_name' => 'person_name',
            'designation' => 'designation',
            'message' => 'm',
            'url' => 'http://www.example.com',
            'order' => 1,
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->postJson('/api/admin/managements', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.message', [
                'The message must be at least 3 characters.'
            ]);
    }

    public function management_message_should_have_maximum_length()
    {
        $payload = [
            'photo' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
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
            messagemessagemessagemessagemessagemessagemessagemessagemessagemessagemessagemessagemessagemessagemessage
            messagemessagemessagemessagemessagemessagemessagemessagemessagemessagemessagemessagemessagemessagemessage
            messagemessagemessagemessagemessagemessagemessagemessagemessagemessagemessagemessagemessagemessagemessage
            messagemessagemessagemessagemessagemessagemessagemessagemessagemessagemessagemessagemessagemessagemessage
            messagemessagemessagemessagemessagemessagemessagemessagemessagemessagemessagemessagemessagemessagemessage',
            'url' => 'http://www.example.com',
            'order' => 1,
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->postJson('/api/admin/managements', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.message', [
                'The message must not be greater than 1000 characters.'
            ]);
    }

    /** @test */
    public function management_order_is_required()
    {
        $payload = [
            'photo' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'person_name' => 'person_name',
            'designation' => 'designation',
            'message' => 'message',
            'url' => 'http://www.example.com',
            'order' => null,
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->postJson('/api/admin/managements', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.order', [
                'The order field is required.'
            ]);
    }

    /** @test */
    public function management_order_should_be_integer_type()
    {
        $payload = [
            'photo' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'person_name' => 'person_name',
            'designation' => 'designation',
            'message' => 'message',
            'url' => 'http://www.example.com',
            'order' => 'a',
        ];
        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->postJson('/api/admin/managements', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.order', [
                'The order must be an integer.'
            ]);
    }
}
