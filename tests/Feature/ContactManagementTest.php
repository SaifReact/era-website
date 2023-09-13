<?php

namespace Tests\Feature;

use App\Models\CompanyInfo;
use App\Models\Contact;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

/**
 * Class ContactManagementTest
 * @package Tests\Feature
 */
class ContactManagementTest extends TestCase
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
    public function contact_can_be_added()
    {
        $payload = [
            'person_name' => 'person_name',
            'designation' => 'designation',
            'contact_no' => '+88 019 0411 9221',
            'primary_contact' => true,
            'order' => 1
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->postJson('/api/admin/contacts', $payload, $headers);

        $this->assertCount(1, Contact::all());

        $response->assertCreated();
    }

    /** @test */
    public function contact_can_be_updated()
    {
        $payload = [
            'person_name' => 'person_name',
            'designation' => 'designation',
            'contact_no' => '+88 019 0411 9221',
            'primary_contact' => false,
            'order' => 1
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $this->postJson('/api/admin/contacts', $payload, $headers);

        $contact = Contact::first();

        $payload1 = [
            'person_name' => 'person_name1',
            'designation' => 'designation1',
            'contact_no' => '+88 019 0411 9222',
            'primary_contact' => false,
            'order' => 2
        ];

        $response = $this->patchJson("/api/admin/contacts/{$contact->id}", $payload1, $headers);

        $contact1 = Contact::first();

        $this->assertEquals('person_name1', $contact1->person_name);
        $this->assertEquals('designation1', $contact1->designation);
        $this->assertEquals(0, $contact1->primary_contact);
        $this->assertEquals(2, $contact1->order);

        $response->assertOk();
    }

    /** @test */
    public function contact_can_be_deleted()
    {
        $payload = [
            'person_name' => 'person_name',
            'designation' => 'designation',
            'contact_no' => '+88 019 0411 9221',
            'primary_contact' => false,
            'order' => 1
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $this->postJson('/api/admin/contacts', $payload, $headers);

        $this->assertCount(1, Contact::all());
        $contact = Contact::first();

        $response = $this->deleteJson("/api/admin/contacts/{$contact->id}");
        $this->assertCount(0, Contact::all());
        $response->assertOk();
    }

    /** @test */
    public function contact_can_be_viewed()
    {
        $payload = [
            'person_name' => 'person_name',
            'designation' => 'designation',
            'contact_no' => '+88 019 0411 9221',
            'primary_contact' => true,
            'order' => 1
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $this->postJson('/api/admin/contacts', $payload, $headers);

        $contact = Contact::first();
        $response = $this->getJson("/api/admin/contacts/{$contact->id}");

        $this->assertEquals('person_name', $contact->person_name);
        $this->assertEquals('designation', $contact->designation);
        $this->assertEquals('+88 019 0411 9221', $contact->contact_no);
        $this->assertEquals(1, $contact->primary_contact);
        $this->assertEquals(1, $contact->order);

        $response->assertOk();
    }

    /** @test */
    public function contact_can_be_listed()
    {
        $payload = [
            'person_name' => 'person_name',
            'designation' => 'designation',
            'contact_no' => '+88 019 0411 9221',
            'primary_contact' => false,
            'order' => 1
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $this->postJson('/api/admin/contacts', $payload, $headers);

        $this->assertCount(1, Contact::all());

        $payload1 = [
            'person_name' => 'person_name1',
            'designation' => 'designation1',
            'contact_no' => '+88 019 0411 9222',
            'primary_contact' => false,
            'order' => 2
        ];


        $this->postJson('/api/admin/contacts', $payload1, $headers);

        $response = $this->getJson('/api/admin/contacts');

        $this->assertCount(2, Contact::all());

        $response->assertOk();
    }

    /** @test */
    public function contact_photo_should_have_correct_url_format()
    {
        $payload = [
            'photo' => 'email@example1.com',
            'person_name' => 'person_name',
            'designation' => 'designation',
            'contact_no' => '+88 019 0411 9221',
            'primary_contact' => true,
            'order' => 1
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->postJson('/api/admin/contacts', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.photo', [
                'The photo must be a valid URL.'
            ]);
    }

    /** @test */
    public function contact_photo_should_have_minimum_length()
    {
        $payload = [
            'photo' => 'http://www.l',
            'person_name' => 'person_name',
            'designation' => 'designation',
            'contact_no' => '+88 019 0411 9221',
            'primary_contact' => true,
            'order' => 1
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->postJson('/api/admin/contacts', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.photo', [
                'The photo must be at least 14 characters.'
            ]);
    }

    /** @test */
    public function contact_photo_should_have_maximum_length()
    {
        $payload = [
            'photo' => 'http://laracms.local/cms_assets/29-200x20029-200x20029-200x20029-200x20029-200x200
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
            'person_name' => 'person_name',
            'designation' => 'designation',
            'contact_no' => '+88 019 0411 9221',
            'primary_contact' => true,
            'order' => 1
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->postJson('/api/admin/contacts', $payload, $headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('errors.photo', [
                'The photo must be a valid URL.',
                'The photo must not be greater than 191 characters.'
            ]);
    }
}
