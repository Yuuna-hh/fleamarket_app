<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CommentRequest;
use App\Models\Item;
use App\Models\Like;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->query('tab', 'all');
        $keyword = $request->query('keyword');

        // 未ログインでマイリストアクセス時は何も表示しない
        if ($tab === 'mylist' && !Auth::check()) {
            $items = collect();
            return view('top.index', compact('items', 'tab', 'keyword'));
        }

        $query = Item::query()->with(['categories', 'purchase'])->withCount('likes')->latest();

        if (Auth::check()) {
            $query->where('user_id', '!=', Auth::id());
        }

        if ($tab === 'mylist') {
            $userId = Auth::id();
            $query->whereHas('likes', function ($q) use ($userId) {
                $q->where('user_id', $userId);
            });
        }

        if (!empty($keyword)) {
            $normalized = trim(str_replace('　', ' ', $keyword));
            $words = preg_split('/\s+/', $normalized, -1, PREG_SPLIT_NO_EMPTY);

            foreach ($words as $word) {
                $query->where('name', 'like', '%' . $word . '%');
            }
        }

        $items = $query->get();

        return view('top.index', compact('items', 'tab', 'keyword'));
    }

    public function show(Item $item)
    {
        $item->loadMissing(['purchase', 'categories'])->loadCount('likes');

        if ($item->purchase) {
            return redirect('/')->with('message', '売り切れの商品です');
        }

        // いいねしたユーザーログイン判定
        $isLiked = Auth::check()
            ? $item->likes()->where('user_id', Auth::id())->exists()
            : false;

        $comments = $item->comments()->with('user')->latest()->get();
        

        return view('item.detail', compact('item','isLiked','comments'));
    }

    public function toggleLike(Item $item)
    {
        $userId = Auth::id();

        $like = Like::where('item_id', $item->id)->where('user_id', $userId)->first();

        if ($like) {
            $like->delete();
        } else {
            Like::create([
                'item_id' => $item->id,
                'user_id' => $userId,
            ]);
        }

        return back();
    }

    public function storeComment(CommentRequest $request, Item $item)
    {
        Comment::create([
            'user_id' => Auth::id(),
            'item_id' => $item->id,
            'comment' => $request->input('comment'),
        ]);

        return back()->with('message', 'コメントを送信しました');
    }
}