<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Item;
use App\Models\Category;

class SellItemTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_register_item_for_sale()
    {
        $user = User::factory()->create();
        $categories = Category::factory()->count(2)->create();

        $response = $this->actingAs($user)->post('/sell', [
            'name' => 'テスト商品',
            'brand' => 'テストブランド',
            'description' => '商品の説明',
            'price' => 5000,
            'condition' => '良好',
            'categories' => $categories->pluck('id')->toArray(),
        ]);

        $this->assertDatabaseHas('items', [
            'name' => 'テスト商品',
            'brand' => 'テストブランド',
            'price' => 5000,
            'user_id' => $user->id,
        ]);

        foreach ($categories as $category) {
            $this->assertDatabaseHas('item_categories', [
                'category_id' => $category->id,
            ]);
        }
    }
}
