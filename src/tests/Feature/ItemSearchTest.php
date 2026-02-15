<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Item;
use App\Models\User;
use App\Models\Like;

class ItemSearchTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_search_items_by_partial_name()
    {
        Item::factory()->create(['name' => '赤いカバン']);
        Item::factory()->create(['name' => '青い靴']);

        $response = $this->get('/?keyword=赤');

        $response->assertSee('赤いカバン');
        $response->assertDontSee('青い靴');
    }

    public function test_search_keyword_is_kept_on_mylist()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create(['name' => '黒い帽子']);

        Like::factory()->create([
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        $response = $this->actingAs($user)->get('/?keyword=黒');

        $response = $this->actingAs($user)->get('/?tab=mylist&keyword=黒');

        $response->assertSee('黒い帽子');
    }
}
