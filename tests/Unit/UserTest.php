<?php

namespace Tests\Unit;

use App\Enums\DateTimeFormat;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use Tests\CreatesApplication;

/**
 * Class UserTest
 * @package Tests\Unit
 */
class UserTest extends TestCase
{
    use CreatesApplication;
    use RefreshDatabase;


    /** @test */
    public function user_can_be_created()
    {
        User::create([
            'name' => 'name',
            'email' => 'email@example1.com',
            'email_verified_at' => DateTimeFormat::store(now()->format(DateTimeFormat::STORE)),
            'password' => 'password',
            'photo' => 'http://laracms.local/cms_assets/1026-200x300.jpg',
            'first_name' => 'first_name',
            'last_name' => 'last_name',
            'send_notification' => true,
            'remember_token' => 'remember_token',
        ]);

        $this->assertCount(3, User::all());
    }
}
