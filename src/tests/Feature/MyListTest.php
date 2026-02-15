<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Item;
use App\Models\Like;
use App\Models\Purchase;

class MyListTest extends TestCase
{
    use RefreshDatabase;

    public function test_only_liked_items_are_displayed()
    {
        $user = User::factory()->create();
        $liked = Item::factory()->create(['name' => 'liked']);
        $notLiked = Item::factory()->create(['name' => 'not-liked']);

        Like::factory()->create([
            'user_id' => $user->id,
            'item_id' => $liked->id,
        ]);

        $response = $this->actingAs($user)->get('/?tab=mylist');

        $response->assertSee('liked');
        $response->assertDontSee('not-liked');
    }

    public function test_purchased_item_is_displayed_as_sold()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        Like::factory()->create([
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        Purchase::factory()->create([
            'item_id' => $item->id,
        ]);

        $response = $this->actingAs($user)->get('/?tab=mylist');
        $response->assertSee('items__sold');
    }

    public function test_guest_sees_nothing_on_mylist()
    {
        $response = $this->get('/?tab=mylist');

        $response->assertDontSee('items__card');
        $response->assertDontSee('items__sold');
    }
}
