@extends('layouts.app')

@section('title', '住所の変更')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/mypage.css') }}">
@endsection

@section('content')
<div class="profile">
    <h1 class="profile__title">住所の変更</h1>

    <form class="profile__form" method="POST" action="{{ url('/purchase/address/' . $item->id) }}" novalidate>
        @csrf

        <div class="profile__field">
            <label class="profile__label" for="postal_code">郵便番号</label>
            <input
                class="profile__input"
                id="postal_code"
                name="postal_code"
                type="text"
                value="{{ old('postal_code', Auth::user()->postal_code) }}"
            >
            @error('postal_code')
                <p class="error-message">{{ $message }}</p>
            @enderror
        </div>

        <div class="profile__field">
            <label class="profile__label" for="address">住所</label>
            <input
                class="profile__input"
                id="address"
                name="address"
                type="text"
                value="{{ old('address', Auth::user()->address) }}"
            >
            @error('address')
                <p class="error-message">{{ $message }}</p>
            @enderror
        </div>

        <div class="profile__field">
            <label class="profile__label" for="building">建物名</label>
            <input
                class="profile__input"
                id="building"
                name="building"
                type="text"
                value="{{ old('building', Auth::user()->building) }}"
            >
            @error('building')
                <p class="error-message">{{ $message }}</p>
            @enderror
        </div>

        <div class="profile__actions">
            <button type="submit" class="btn">更新する</button>
        </div>
    </form>
</div>
@endsection
