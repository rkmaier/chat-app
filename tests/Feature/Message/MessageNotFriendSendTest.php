<?php

namespace Tests\Feature\Message;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MessageNotFriendSendTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_message_not_friends(): void
    {
        $sender = User::factory()->create();
        $receiver = User::factory()->create();

        $response = $this->actingAs($sender)->postJson("/api/messages/{$receiver->id}", [
            'body' => 'Hello, world!',
        ]);

        $response->assertJson(['message' => __('Users are not friends.')]);
        $response->assertStatus(403);
    }
}
