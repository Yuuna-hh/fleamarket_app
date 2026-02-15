<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Item;
use App\Models\Purchase;
use App\Http\Middleware\VerifyCsrfToken;

class PurchaseTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutMiddleware(VerifyCsrfToken::class);
    }

    public function test_user_can_purchase_item()
    {
        $seller = User::factory()->create();
        $buyer  = User::factory()->create();

        $item = Item::factory()->create([
            'user_id' => $seller->id,
        ]);

        $response = $this->actingAs($buyer)
            ->withSession([
                'shipping_postal_code' => '123-4567',
                'shipping_address' => '東京都渋谷区1-1-1',
                'shipping_building' => null,
            ])
            ->post("/purchase/{$item->id}", [
                'payment_method' => 'card',
            ]);

        $response->assertStatus(302);
        
        $this->assertDatabaseHas('purchases', [
            'user_id' => $buyer->id,
            'item_id' => $item->id,
        ]);
    }

    public function test_purchased_item_is_displayed_as_sold_on_list()
    {
        $buyer = User::factory()->create();
        $item = Item::factory()->create();

        Purchase::factory()->create([
            'user_id' => $buyer->id,
            'item_id' => $item->id,
        ]);

        $response = $this->get('/');
        $response->assertSee('items__sold');
    }

    public function test_purchased_item_is_shown_on_profile()
    {
        $buyer = User::factory()->create();
        $item = Item::factory()->create();

        Purchase::factory()->create([
            'user_id' => $buyer->id,
            'item_id' => $item->id,
        ]);

        $response = $this->actingAs($buyer)->get('/mypage?page=buy');

        $response->assertSee($item->name);
    }
}
