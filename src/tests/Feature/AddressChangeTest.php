<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Item;
use App\Models\Purchase;
use App\Http\Middleware\VerifyCsrfToken;

class AddressChangeTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutMiddleware(VerifyCsrfToken::class);
    }

    public function test_address_change_is_reflected_on_purchase_page()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $response = $this->actingAs($user)
        ->followingRedirects()
        ->patch("/purchase/address/{$item->id}", [
            'postal_code' => '123-4567',
            'address' => '東京都渋谷区1-1-1',
        ]);

        $response->assertSee('123-4567');
        $response->assertSee('東京都渋谷区1-1-1');
    }

    public function test_address_is_attached_on_purchase()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $this->actingAs($user)
            ->post("/purchase/address/{$item->id}", [
                'postal_code' => '123-4567',
                'address' => '東京都渋谷区1-1-1',
            ]);

        $this->actingAs($user)
            ->post("/purchase/{$item->id}", [
                'payment_method' => 'card',
            ]);

        $this->assertDatabaseHas('purchases', [
            'item_id' => $item->id,
            'shipping_postal_code' => '123-4567',
            'shipping_address' => '東京都渋谷区1-1-1',
        ]);
    }
}
