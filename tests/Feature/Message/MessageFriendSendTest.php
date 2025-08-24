<?php

namespace Message;

use App\Models\Friend;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class MessageFriendSendTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_message_not_friends(): void
    {
        // Create two verified users
        $user = User::factory()->create(['email_verified_at' => now()]);
        $friend = User::factory()->create(['email_verified_at' => now()]);

        [$u, $f] = $user->id < $friend->id ? [$user->id, $friend->id] : [$friend->id, $user->id];

        Friend::create([
            'user_id' => $u,
            'friend_id' => $f,
            'status' => 'accepted',
            'requested_by' => $user->id,
        ]);

        Sanctum::actingAs($user);
        $resp = $this->postJson("/api/messages/{$friend->id}", [
            'body' => 'Hello World!',
        ], ['Accept' => 'application/json']);

        $resp->assertCreated()
            ->assertJsonStructure([
                'id', 'sender_id', 'receiver_id', 'body', 'created_at', 'updated_at'
            ])
            ->assertJson([
                'sender_id' => $user->id,
                'receiver_id' => $friend->id,
                'body' => 'Hello World!',
            ]);

        $this->assertDatabaseHas('messages', [
            'sender_id' => $user->id,
            'receiver_id' => $friend->id,
            'body' => 'Hello World!',
        ]);

    }
}
