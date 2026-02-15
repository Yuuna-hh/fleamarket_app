@extends('layouts.app')

@section('title', 'ログイン')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
@endsection

@section('content')
<div class="auth">
    <div class="auth__card">
        <h1 class="auth__title">ログイン</h1>

        <form method="POST" action="{{ route('login') }}" class="auth__form" novalidate>
            @csrf
            <input type="hidden" name="redirect" value="{{ request('redirect') }}">
            
            <div class="auth__field">
                <label class="auth__label" for="email">メールアドレス</label>
                <input class="auth__input" id="email" name="email" type="email" value="{{ old('email') }}" autocomplete="email">
                @error('email')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <div class="auth__field">
                <label class="auth__label" for="password">パスワード</label>
                <input class="auth__input" id="password" name="password" type="password" autocomplete="current-password">
                @error('password')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="btn">ログインする</button>
        </form>

        <div class="auth__bottom">
            <a href="{{ route('register') }}" class="auth__link">会員登録はこちら</a>
        </div>
    </div>
</div>
@endsection
