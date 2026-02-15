<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Item;
use App\Models\Purchase;

class ItemListTest extends TestCase
{
    use RefreshDatabase;

    public function test_all_items_are_displayed()
    {

        $items = Item::factory()->count(2)->create();

        $response = $this->get('/');


        foreach ($items as $item) {
            $response->assertSee($item->name);
        }
    }

    public function test_purchased_item_is_displayed_as_sold()
    {
        $item = Item::factory()->create();

        Purchase::factory()->create([
            'item_id' => $item->id,
        ]);

        $response = $this->get('/');

        $response->assertSee('items__sold');
    }

    public function test_own_items_are_not_displayed()
    {
        $user = User::factory()->create();

        $ownItem = Item::factory()->create([
            'user_id' => $user->id,
            'name' => '自分の商品',
        ]);

        $otherItem = Item::factory()->create([
            'name' => '他人の商品',
        ]);

        $response = $this->actingAs($user)->get('/');

        $response->assertDontSee('自分の商品');
        $response->assertSee('他人の商品');
    }
}
