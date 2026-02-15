@extends('layouts.app')

@section('title', '会員登録')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
@endsection

@section('content')
<div class="auth">
    <div class="auth__card">
        <h1 class="auth__title">会員登録</h1>

        <form method="POST" action="{{ route('register') }}" class="auth__form" novalidate>
            @csrf

            <div class="auth__field">
                <label class="auth__label" for="name">ユーザー名</label>
                <input class="auth__input" id="name" name="name" type="text" value="{{ old('name') }}">
                @error('name') <p class="error-message">{{ $message }}</p> @enderror
            </div>

            <div class="auth__field">
                <label class="auth__label" for="email">メールアドレス</label>
                <input class="auth__input" id="email" name="email" type="email" value="{{ old('email') }}">
                @error('email') <p class="error-message">{{ $message }}</p> @enderror
            </div>

            <div class="auth__field">
                <label class="auth__label" for="password">パスワード</label>
                <input class="auth__input" id="password" name="password" type="password">
                @error('password') <p class="error-message">{{ $message }}</p> @enderror
            </div>

            <div class="auth__field">
                <label class="auth__label" for="password_confirmation">確認用パスワード</label>
                <input class="auth__input" id="password_confirmation" name="password_confirmation" type="password">
                @error('password_confirmation') <p class="error-message">{{ $message }}</p> @enderror
            </div>

            <button type="submit" class="btn">登録する</button>
        </form>

        <div class="auth__bottom">
            <a href="{{ route('login') }}" class="auth__link">ログインはこちら</a>
        </div>
    </div>
</div>
@endsection
