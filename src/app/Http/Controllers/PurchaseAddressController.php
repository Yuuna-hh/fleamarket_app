<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\AddressRequest;

class PurchaseAddressController extends Controller
{
    public function edit(Item $item)
    {
        return view('purchase.address', compact('item'));
    }

    public function update(AddressRequest $request, Item $item)
    {
        $validated = $request->validated();
        $user = Auth::user();  

        $request->session()->put([
            'shipping_postal_code' => $validated['postal_code'],
            'shipping_address'     => $validated['address'],
            'shipping_building'    => $validated['building'] ?? null,
        ]);

        return redirect()->route('purchase.show', ['item' => $item->id]);
    }
}