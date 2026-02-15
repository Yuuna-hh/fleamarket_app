@extends('layouts.app')

@section('title', '購入画面')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/purchase.css') }}">
@endsection

@section('content')
@php
    $itemImageUrl = $item->image_path ? asset($item->image_path) : null;
@endphp

<div class="purchase">

    <!-- 商品情報 -->
    <div class="purchase__left">
        <div class="purchase__item">
            <div class="purchase__image">
                <img src="{{ $item->image_url }}" alt="{{ $item->name }}">
            </div>

            <div class="purchase__info">
                <p class="purchase__name">{{ $item->name }}</p>
                <p class="purchase__price">¥ {{ number_format($item->price) }}</p>
            </div>
        </div>

        <!-- 購入情報 -->
        <hr class="purchase__hr">

        <form method="POST" action="{{ url('/purchase/' . $item->id) }}" class="purchase__form" novalidate>
            @csrf

            <div class="purchase__section">
                <p class="purchase__sectionTitle">支払い方法</p>

                <select name="payment_method" class="purchase__select" id="paymentSelect">
                    <option value="" selected disabled hidden>選択してください</option>
                    <option value="convenience">コンビニ支払い</option>
                    <option value="card">カード支払い</option>
                </select>

                @error('payment_method')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <hr class="purchase__hr">

            <div class="purchase__section">
                <div class="purchase__addressHead">
                    <p class="purchase__sectionTitle">配送先</p>
                    <a href="{{ url('/purchase/address/' . $item->id) }}" class="purchase__addressLink">
                        変更する
                    </a>
                </div>

                <div class="purchase__addressBody">
                    <p>〒 {{ $postalCode }}</p>
                    <p>{{ $address }}</p>
                    @if ($building)
                        <p>{{ $building }}</p>
                    @endif
                </div>
            </div>

            <button type="submit" id="hiddenSubmit" class="purchase__hiddenSubmit"></button>
        </form>
    </div>

    <!-- 右側サマリ -->
    <div class="purchase__right">
        <div class="purchase__summary">
            <div class="purchase__summaryCell purchase__summaryCell--label">商品代金</div>
            <div class="purchase__summaryCell purchase__summaryCell--value">¥ {{ number_format($item->price) }}</div>

            <div class="purchase__summaryCell purchase__summaryCell--label">支払い方法</div>
            <div class="purchase__summaryCell purchase__summaryCell--value" id="paymentLabel">未選択</div>
        </div>

        <button type="button" id="buyButton" class="btn">
            購入する
        </button>
    </div>
</div>
@endsection

@section('js')
    <script src="{{ asset('js/purchase.js') }}"></script>
@endsection
