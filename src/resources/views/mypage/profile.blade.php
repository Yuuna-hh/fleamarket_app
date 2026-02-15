@extends('layouts.app')

@section('title', 'プロフィール設定')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/mypage.css') }}">
@endsection

@section('content')
@php
    $avatarUrl = Auth::user()->profile_image_path
        ? Storage::url(Auth::user()->profile_image_path)
        : null;
@endphp

<div class="profile">
    <h1 class="profile__title">プロフィール設定</h1>

    <form class="profile__form" method="POST" action="{{ url('/mypage/profile') }}" enctype="multipart/form-data" novalidate>
        @csrf

        <input type="hidden" name="redirect_to" value="{{ request('redirect', '/mypage') }}">
        
        <div class="profile__top">
            <div class="profile__avatar" id="profilePreviewArea">
                <img src="{{ $avatarUrl ?? '' }}" alt="プロフィール画像">
            </div>

            <div class="profile__imageArea">
                <label class="profile__btn">
                    画像を選択する
                    <input type="file" name="profile_image" class="profile__fileInput" accept="image/*" data-preview-input data-preview-area="#profilePreviewArea">
                </label>
                @error('profile_image')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="profile__field">
            <label class="profile__label" for="name">ユーザー名</label>
            <input class="profile__input" id="name" name="name" type="text" value="{{ old('name', Auth::user()->name) }}">
            @error('name')
                <p class="error-message">{{ $message }}</p>
            @enderror
        </div>

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

@section('js')
    <script src="{{ asset('js/image-preview.js') }}"></script>
@endsection
