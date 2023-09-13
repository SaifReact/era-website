<?php

namespace Tests\Feature;

use App\Enums\DateTimeFormat;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable as UserContract;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use Laravel\Sanctum\Sanctum;

/**
 * Class UserManagementTest
 * @package Tests\Feature
 */
class UserManagementTest extends TestCase
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
    public function user_can_be_registered()
    {
        $this->withoutExceptionHandling();

        $payload = [
            'name' => 'name',
            'email' => 'email@example1.com',
            'email_verified_at' => DateTimeFormat::store(now()->format(DateTimeFormat::STORE)),
            'password' => 'password',
            'password_confirmation' => 'password',
            'photo' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'first_name' => 'first_name',
            'last_name' => 'last_name',
            'send_notification' => true,
            'remember_token' => 'remember_token',
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->postJson('/api/admin/register', $payload, $headers);

        $this->assertCount(4, User::all());
        $response->assertCreated();
    }

    /*public function user_can_be_login()
    {
        $payload = [
            'name' => 'name',
            'email' => 'email@example1.com',
            'email_verified_at' => DateTimeFormat::store(now()->format(DateTimeFormat::STORE)),
            'password' => 'password',
            'password_confirmation' => 'password',
            'photo' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'first_name' => 'first_name',
            'last_name' => 'last_name',
            'send_notification' => 1,
            'remember_token' => 'remember_token',
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $this->postJson('/api/admin/register', $payload, $headers);

        $this->assertCount(1, User::all());

        $payload1 = [
            'email' => 'email@example1.com',
            'password' => 'password',
        ];

        $response1 = $this->postJson('/api/admin/login', $payload1, $headers);

        $response1->assertJson([
            'status' => true,
            'message' => 'User is logged in!',
            'data' => [
                'email' => 'email@example1.com',
            ],
        ]);

        $response1->assertOk();
    }

    public function user_can_be_logout()
    {
        $payload = [
            'name' => 'name',
            'email' => 'email@example1.com',
            'email_verified_at' => DateTimeFormat::store(now()->format(DateTimeFormat::STORE)),
            'password' => 'password',
            'password_confirmation' => 'password',
            'photo' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'first_name' => 'first_name',
            'last_name' => 'last_name',
            'send_notification' => 1,
            'remember_token' => 'remember_token',
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $this->postJson('/api/admin/register', $payload, $headers);

        $this->assertCount(1, User::all());

        $payload1 = [
            'email' => 'email@example1.com',
            'password' => 'password',
        ];

        $response = $this->postJson('/api/admin/login', $payload1, $headers);

        $response = $this->postJson('/api/admin/logout');

        $response->assertJson([
            'status' => true,
            'message' => 'User logged out!',
            'data' => null,
        ]);

        $response->assertOk();
    }*/
}
