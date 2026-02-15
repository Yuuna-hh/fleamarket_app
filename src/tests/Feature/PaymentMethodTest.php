<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Item;

class PaymentMethodTest extends TestCase
{
    use RefreshDatabase;

    public function test_payment_method_change_is_reflected()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();


        $response = $this->actingAs($user)->post("/purchase/{$item->id}/payment", [
            'payment_method' => 'card',
        ]);

        $response = $this->actingAs($user)->get("/purchase/{$item->id}");

        $response->assertSee('card');
    }
}
