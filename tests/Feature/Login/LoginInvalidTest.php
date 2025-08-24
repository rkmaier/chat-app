<?php

namespace Login;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginInvalidTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_login_invalid(): void
    {
        $resp = $this->postJson('/api/register', [
            'name' => 'test',
            'email' => 'test@gmail.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $user = User::first();
        $user->email_verified_at = now();
        $user->save();
        $this->assertSame('test', $user->name);
        $this->assertSame('test@gmail.com', $user->email);
        $resp->assertStatus(201);

        $resp = $this->postJson('/api/login', [
            'email' => 'test@gmail.com',
            'password' => 'password2',
        ]);

        $resp->assertJson([
            'message' => __('Invalid credentials'),
        ]);

        $resp->assertStatus(422);
    }

}
