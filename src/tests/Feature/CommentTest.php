<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Item;
use App\Models\Comment;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_post_comment()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $this->actingAs($user)->post("/item/{$item->id}/comment", [
            'comment' => 'コメントです',
        ]);

        $this->assertDatabaseHas('comments', [
            'user_id' => $user->id,
            'item_id' => $item->id,
            'comment' => 'コメントです',
        ]);
    }

    public function test_guest_cannot_post_comment()
    {
        $item = Item::factory()->create();

        $this->post("/item/{$item->id}/comment", [
            'comment' => 'コメント',
        ]);

        $this->assertDatabaseCount('comments', 0);
    }

    public function test_comment_is_required()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $response = $this->actingAs($user)->post("/item/{$item->id}/comment", [
            'comment' => '',
        ]);

        $response->assertSessionHasErrors('comment');
    }

    public function test_comment_must_be_within_255_characters()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $response = $this->actingAs($user)->post("/item/{$item->id}/comment", [
            'comment' => str_repeat('a', 256),
        ]);

        $response->assertSessionHasErrors('comment');
    }
}
