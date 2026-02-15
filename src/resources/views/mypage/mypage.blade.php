@extends('layouts.app')

@section('title', 'マイページ')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/mypage.css') }}">
    <link rel="stylesheet" href="{{ asset('css/item.css') }}">
@endsection

@section('content')
@php
    $page = request('page', 'sell');
    $user = Auth::user();
    $avatarUrl = $user?->profile_image_path ? Storage::url($user->profile_image_path) : null;

    $items = $page === 'buy' ? ($buyItems ?? collect()) : ($sellItems ?? collect());
@endphp

<div class="mypage">
    <div class="mypage__profileWrapper">
        <div class="mypage__profile">
            <div class="mypage__profile-left">
                <div class="profile__avatar">
                    @if ($avatarUrl)
                        <img src="{{ $avatarUrl }}" alt="プロフィール画像">
                    @endif
                </div>

                <div class="mypage__name">
                    {{ $user->name ?? '' }}
                </div>
            </div>

            <div class="mypage__profile-right">
                <a href="{{ url('/mypage/profile?redirect=/mypage') }}" class="profile__btn">
                    プロフィールを編集
                </a>
            </div>
        </div>
    </div>

        <div class="items__tabs">
            <a
                class="items__tab {{ $page === 'sell' ? 'active' : '' }}"
                href="{{ url('/mypage?page=sell') }}"
            >
                出品した商品
            </a>
            <a
                class="items__tab {{ $page === 'buy' ? 'active' : '' }}"
                href="{{ url('/mypage?page=buy') }}"
            >
                購入した商品
            </a>
        </div>

        <div class="items__grid">
            @forelse ($items as $item)
                @if ($item->purchase)
                    <div class="items__card items__card--sold">
                        <div class="items__card-img">
                            <img src="{{ $item->image_url }}" alt="{{ $item->name }}">
                            <span class="items__sold"></span>
                        </div>
                        <div class="items__card-name">
                            {{ $item->name }}
                        </div>
                    </div>
                @else
                    <a href="{{ url('/item/' . $item->id) }}" class="items__card">
                        <div class="items__card-img">
                            <img src="{{ $item->image_url }}" alt="{{ $item->name }}">
                        </div>
                        <div class="items__card-name">
                            {{ $item->name }}
                        </div>
                    </a>
                @endif
            @empty
                <p class="items__empty">
                    @if ($page === 'sell')
                        出品した商品がありません
                    @else
                        購入した商品がありません
                    @endif
                </p>
            @endforelse
        </div>
</div>
@endsection
