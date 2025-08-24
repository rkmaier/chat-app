<?php

namespace Tests\Feature\Friend;

use App\Models\Friend;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class FriendsTest extends TestCase
{
    use RefreshDatabase;

    public function test_verified_users_can_create_and_accept_friendship(): void
    {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $friend = User::factory()->create(['email_verified_at' => now()]);


        Sanctum::actingAs($user);
        $this->postJson("/api/friends/{$friend->id}")->assertOk();


        Sanctum::actingAs($friend);
        $response = $this->postJson("/api/friends/{$user->id}/accept")->assertOk();

        $this->assertDatabaseHas('friends', [
            'status' => Friend::STATUS_ACCEPT,
        ]);

        $response->assertJson(['message' => __('Friend request accepted.')]);
    }
}
