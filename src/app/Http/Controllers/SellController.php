<?php

namespace App\Http\Controllers;

use App\Http\Requests\SellRequest;
use App\Models\Category;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;

class SellController extends Controller
{
    public function create()
    {
        $categories = Category::orderBy('id')->get();

        return view('sell.sell', compact('categories'));
    }

    public function store(SellRequest $request)
    {
        $validated = $request->validated();

        $path = null;
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('items', 'public');
        }

        $item = Item::create([
            'user_id' => Auth::id(),
            'name' => $validated['name'],
            'brand' => $validated['brand'] ?? null,
            'description' => $validated['description'],
            'price' => $validated['price'],
            'condition' => $validated['condition'],
            'image_path' => $path,
        ]);

        $item->categories()->sync($validated['categories']);

        return redirect('/')->with('message', '商品を出品しました');
    }
}
