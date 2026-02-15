<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;

class MypageController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $page = $request->query('page', 'sell');

        $sellItems = Item::where('user_id', $user->id)
            ->with('purchase')
            ->latest()
            ->get();

        $buyItems = Item::whereHas('purchase', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            })
            ->with('purchase')
            ->latest()
            ->get();

        return view('mypage.mypage', compact('sellItems', 'buyItems', 'page'));
    }
}
