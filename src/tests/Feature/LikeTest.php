<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Item;
use App\Models\Like;

class LikeTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_like_item()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $response = $this->actingAs($user)
            ->post(route('items.like.toggle', $item->id));

        $this->assertDatabaseHas('likes', [
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);
    }

    public function test_liked_item_shows_pushed_icon_on_detail_page()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        Like::factory()->create([
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        $response = $this->actingAs($user)
            ->get(route('items.show', $item->id));

        $response->assertSee('Fav_pushed.png');
    }

    public function test_user_can_unlike_item()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        Like::factory()->create([
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        $this->actingAs($user)
            ->post(route('items.like.toggle', $item->id));

        $this->assertDatabaseMissing('likes', [
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);
    }
}
