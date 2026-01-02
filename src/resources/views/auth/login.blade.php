<!doctype html>
<html lang="ja">
<body>
<h1>Login</h1>
@if ($errors->any())
    <ul>@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
@endif
<form method="POST" action="{{ route('login') }}">
    @csrf
    <input type="email" name="email" value="{{ old('email') }}" placeholder="email" required>
    <input type="password" name="password" placeholder="password" required>
    <label><input type="checkbox" name="remember"> remember</label>
    <button type="submit">Login</button>
</form>
</body>
</html>