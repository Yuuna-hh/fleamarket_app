<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Item;
use App\Models\Purchase;

class UserProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_profile_displays_required_information()
    {
        $user = User::factory()->create([
            'name' => 'テストユーザー',
        ]);

        $sellItem = Item::factory()->create([
            'user_id' => $user->id,
            'name' => '出品商品',
        ]);

        $buyItem = Item::factory()->create([
            'name' => '購入商品',
        ]);

        Purchase::factory()->create([
            'user_id' => $user->id,
            'item_id' => $buyItem->id,
        ]);

        $response = $this->actingAs($user)->get('/mypage');

        $response->assertSee('テストユーザー');
        $response = $this->actingAs($user)->get('/mypage?page=buy');
        $response->assertSee('購入商品');
    }
}
