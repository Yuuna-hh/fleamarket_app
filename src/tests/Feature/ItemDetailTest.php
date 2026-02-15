<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Item;
use App\Models\Category;
use App\Models\User;
use App\Models\Comment;

class ItemDetailTest extends TestCase
{
    use RefreshDatabase;

    public function test_item_detail_displays_required_information()
    {
        $user = User::factory()->create(['name' => '出品者']);
        $item = Item::factory()->create([
            'name' => 'テスト商品',
            'description' => '説明文',
            'price' => 1000,
            'user_id' => $user->id,
        ]);

        Comment::factory()->create([
            'item_id' => $item->id,
            'comment' => 'コメント内容',
        ]);

        $response = $this->get("/item/{$item->id}");

        $response->assertSee('テスト商品');
        $response->assertSee('説明文');
        $response->assertSee('1,000');
        $response->assertSee('コメント内容');
    }

    public function test_multiple_categories_are_displayed()
    {
        $item = Item::factory()->create();
        $categories = Category::factory()->count(2)->create();

        $item->categories()->attach($categories->pluck('id'));

        $response = $this->get("/item/{$item->id}");

        foreach ($categories as $category) {
            $response->assertSee($category->name);
        }
    }
}
