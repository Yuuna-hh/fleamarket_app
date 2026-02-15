@extends('layouts.app')

@section('title', '商品詳細')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/item.css') }}">
@endsection

@section('content')
@php
    $isLiked = $isLiked ?? false;
@endphp

<div class="item-detail">
    <div class="item-detail__inner">

        <!-- 商品画像 -->
        <div class="item-detail__image">
            <div class="item-detail__image-box">
                <img src="{{ $item->image_url }}" alt="{{ $item->name }}">
            </div>
        </div>

        <!-- 商品情報 -->
        <div class="item-detail__info">
            <h1 class="item-detail__name">{{ $item->name }}</h1>

            <!-- ブランド名：nullなら空欄 -->
            @if(!empty($item->brand))
                <p class="item-detail__brand">{{ $item->brand }}</p>
            @endif

            <p class="item-detail__price">
                ¥{{ number_format($item->price) }} <span class="item-detail__tax">（税込）</span>
            </p>

            <!-- いいね＆コメント -->
            <div class="item-detail__social">

                <!-- いいね -->
                <div class="item-detail__social-item">
                    @auth
                        <form method="POST" action="{{ route('items.like.toggle', $item->id) }}">
                            @csrf
                            <button class="icon-btn" type="submit" aria-label="いいね">
                                <img
                                    class="icon-img"
                                    src="{{ asset('images/icon/' . ($isLiked ? 'Fav_pushed.png' : 'Fav_empty.png')) }}"
                                    alt="fav"
                                >
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login', ['redirect' => url()->current()]) }}" class="icon-btn" aria-label="ログインしていいね">
                            <img class="icon-img" src="{{ asset('images/icon/Fav_empty.png') }}" alt="fav">
                        </a>
                    @endauth
                    <span class="count">{{ $item->likes_count ?? 0 }}</span>
                </div>

                <!-- コメント -->
                <a href="#comments" class="item-detail__social-item item-detail__social-item--link" aria-label="コメント欄へ">
                    <img class="icon-img" src="{{ asset('images/icon/Comment.png') }}" alt="comment">
                    <span class="count">{{ $comments->count() }}</span>
                </a>
            </div>

            <!-- 購入ボタン -->
            <button
                type="button" class="btn btn--purchase"
                @guest
                    onclick="location.href='{{ route('login', ['redirect' => url("/purchase/{$item->id}")]) }}'"
                @else
                    @if(Auth::id() === $item->user_id)
                        onclick="this.nextElementSibling.style.display='block';"
                    @else
                        onclick="location.href='{{ url("/purchase/{$item->id}") }}'"
                    @endif
                @endguest
            >
                購入手続きへ
            </button>

            @auth
                @if(Auth::id() === $item->user_id)
                    <p class="error-message" style="display: none;">
                        自分が出品した商品は購入できません
                    </p>
                @endif
            @endauth

            <!-- 商品説明 -->
            <section class="item-detail__section">
                <h2 class="item-detail__section-title">商品説明</h2>
                <div class="item-detail__desc">
                    {!! nl2br(e($item->description)) !!}
                </div>
            </section>

            <!-- 商品の情報 -->
            <section class="item-detail__section">
                <h2 class="item-detail__section-title">商品の情報</h2>

                <div class="item-detail__meta">
                    <div class="item-detail__meta-row">
                        <span class="item-detail__meta-label">カテゴリー</span>
                        <span class="item-detail__meta-value item-detail__meta-value--tags">
                            @forelse($item->categories as $category)
                                <span class="item-detail__tag">{{ $category->name }}</span>
                            @empty
                                <span class="item-detail__meta-empty">—</span>
                            @endforelse
                        </span>
                    </div>

                    <div class="item-detail__meta-row">
                        <span class="item-detail__meta-label">商品の状態</span>
                        <span class="item-detail__meta-value">{{ $item->condition_label ?? ($item->condition ?? '—') }}</span>
                    </div>
                </div>
            </section>

            <!-- コメント一覧 -->
            <section class="item-detail__section" id="comments">
                <h2 class="item-detail__section-title item-detail__section-title--comment">コメント（{{ $comments->count() }}）</h2>

                <div class="comments">
                    @forelse($comments as $comment)
                        @php
                            $profilePath = $comment->user?->profile_image_path;
                        @endphp

                        <div class="comment">
                            <div class="comment__avatar">
                                <img
                                    src="{{ $profilePath ? Storage::url($profilePath) : asset('images/dummy_user.png') }}"
                                    alt="プロフィール画像"
                                >
                            </div>

                            <div class="comment__body">
                                <div class="comment__name">{{ $comment->user?->name ?? 'unknown' }}</div>
                                <div class="comment__text">{!! nl2br(e($comment->comment)) !!}</div>
                            </div>
                        </div>
                    @empty
                        <p class="comments__empty">まだコメントはありません。</p>
                    @endforelse
                </div>
            </section>

            <!-- コメント投稿 -->
            <section class="item-detail__section">
                <h3 class="item-detail__section-title">商品へのコメント</h3>

                    @auth
                        <form method="POST" action="{{ route('items.comments.store', $item->id) }}">
                            @csrf

                            <textarea class="comment-form__textarea" name="comment" rows="5" placeholder="コメントを入力してください">{{ old('comment') }}</textarea>

                            @error('comment')
                                <p class="error-message">{{ $message }}</p>
                            @enderror

                            <button class="btn btn--comment" type="submit">
                                コメントを送信する
                            </button>
                        </form>
                    @else
                        <!-- 未ログイン時は、送信でログインへ -->
                        <form method="GET" action="{{ route('login') }}">
                            <input type="hidden" name="redirect" value="{{ url()->current() }}#comments">
                            <textarea class="comment-form__textarea" rows="5" placeholder="コメントを入力してください" readonly></textarea>
                            <button class="btn btn--comment" type="submit">コメントを送信する</button>
                        </form>
                    @endauth
            </section>

        </div>
    </div>
</div>
@endsection
