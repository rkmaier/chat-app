<?php

namespace Registration;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_registration(): void
    {
        $resp = $this->postJson('/api/register', [
            'name' => 'test',
            'email' => 'test@gmail.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $user = User::first();
        $this->assertNull($user->email_verified_at);
        $this->assertSame('test', $user->name);
        $this->assertSame('test@gmail.com', $user->email);
        $resp->assertStatus(201);
    }


}
