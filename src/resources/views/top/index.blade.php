@extends('layouts.app')

@section('title', '商品一覧')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/item.css') }}">
@endsection

@section('content')
@php
    $tab = request('tab', 'all');
    $keyword = request('keyword');
@endphp

<div class="items">
    <div class="items__tabs">
        <a
            class="items__tab {{ $tab === 'all' ? 'active' : '' }}"
            href="{{ url('/').($keyword ? ('?keyword='.urlencode($keyword)) : '') }}"
        >
            おすすめ
        </a>
        <a
            class="items__tab {{ $tab === 'mylist' ? 'active' : '' }}"
            href="{{ url('/?tab=mylist').($keyword ? ('&keyword='.urlencode($keyword)) : '') }}"
        >
            マイリスト
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
            @if (!empty($keyword))
                <p class="items__empty">
                    「{{ $keyword }}」の検索結果がありません
                </p>
            @elseif ($tab === 'mylist' && Auth::check())
                <p class="items__empty">
                    いいねした商品がありません
                </p>
            @elseif ($tab === 'all')
                <p class="items__empty">
                    商品がありません
                </p>
            @endif
        @endforelse
    </div>
</div>
@endsection
