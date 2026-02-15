<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Purchase;
use App\Http\Requests\PurchaseRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Stripe\Stripe;
use Stripe\Checkout\Session as CheckoutSession;

class PurchaseController extends Controller
{
    public function show(Item $item)
    {
        if ($redirect = $this->guard($item)) return $redirect;

        $user = Auth::user();

        $postalCode = session('shipping_postal_code', $user->postal_code);
        $address = session('shipping_address', $user->address);
        $building = session('shipping_building', $user->building);

        return view('purchase.purchase', compact(
            'item',
            'user',
            'postalCode',
            'address',
            'building'
        ));
    }

    public function store(PurchaseRequest $request, Item $item)
    {
        if ($redirect = $this->guard($item)) return $redirect;

        $validated = $request->validated();
        $user = Auth::user();

        // テスト用　Stripeを通さず即購入
        if (app()->environment('testing')) {
            Purchase::create([
                'user_id'        => $user->id,
                'item_id'        => $item->id,
                'payment_method' => $validated['payment_method'],
                'shipping_postal_code' => session('shipping_postal_code'),
                'shipping_address' => session('shipping_address'),
                'shipping_building' => session('shipping_building'),
            ]);

            return redirect('/');
        }

        // 本番用
        Stripe::setApiKey(config('services.stripe.secret'));

        if ($validated['payment_method'] === 'convenience') {
            $this->createPurchase($item, $user, 'convenience');
        }
        
        $paymentType = $validated['payment_method'] === 'card'
            ? 'card'
            : 'konbini';

        $session = CheckoutSession::create([
            'mode' => 'payment',
            'payment_method_types' => [$paymentType],
            'line_items' => [[
                'quantity' => 1,
                'price_data' => [
                    'currency' => 'jpy',
                    'unit_amount' => (int) $item->price,
                    'product_data' => ['name' => $item->name],
                ],
            ]],
            'success_url' => route('purchase.success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url'  => url("/purchase/{$item->id}?stripe=cancel"),
            'metadata' => [
                'item_id' => (string) $item->id,
                'user_id' => (string) $user->id,
                'payment_method' => $validated['payment_method'],
            ],
        ]);

        return redirect()->away($session->url);
    }

    public function success(Request $request)
    {
        $sessionId = $request->query('session_id');
        if (!$sessionId) {
            return redirect('/')->with('message', '決済情報が取得できませんでした');
        }

        Stripe::setApiKey(config('services.stripe.secret'));

        try {
            $session = CheckoutSession::retrieve($sessionId);
        } catch (\Exception $e) {
            return redirect('/')->with('message', '決済情報の取得に失敗しました');
        }

        $itemId = (int)($session->metadata->item_id ?? 0);
        $userId = (int)($session->metadata->user_id ?? 0);
        $method = (string)($session->metadata->payment_method ?? 'card');

        $item = Item::findOrFail($itemId);
        $user = \App\Models\User::findOrFail($userId);
        
        if ($item->purchase()->exists()) {
            return redirect('/')->with('success', '購入が完了しました');
        }

        if ($method === 'card') {
            if (($session->payment_status ?? null) !== 'paid') {
                return redirect('/')->with('message', '決済が完了していません');
            }

            $this->createPurchase($item, $user, 'card');
        }

        return redirect('/')->with('success', '購入が完了しました');
    }

    private function guard(Item $item)
    {
        $user = Auth::user();

        if ($item->user_id === $user->id) {
            return redirect()->route('items.show', $item)
                ->with('message', '自分が出品した商品は購入できません');
        }

        if ($item->purchase()->exists()) {
            return redirect()->route('items.show', $item)
                ->with('message', '売り切れの商品です');
        }

        return null;
    }

    private function createPurchase(Item $item, $user, string $method): void
    {
        DB::transaction(function () use ($item, $user, $method) {
            if (Purchase::where('item_id', $item->id)->exists()) {
                abort(409, '売り切れの商品です');
            }

            $postalCode = session('shipping_postal_code', $user->postal_code);
            $address    = session('shipping_address', $user->address);
            $building   = session('shipping_building', $user->building);

            Purchase::create([
                'user_id' => $user->id,
                'item_id' => $item->id,
                'payment_method' => $method,
                'shipping_postal_code' => $postalCode,
                'shipping_address'     => $address,
                'shipping_building'    => $building,
            ]);
        });
    }
}