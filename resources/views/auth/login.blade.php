@extends('layouts.auth')
@section('title', 'Login')

@section('content')
    <h1 class="auth-title">Selamat Datang</h1>
    <p class="auth-subtitle">Masuk ke akun Anda untuk melanjutkan</p>

    @if (session('status'))
        <p class="alert alert-success" role="status">{{ session('status') }}</p>
    @endif

    <form method="POST" action="{{ route('login.submit') }}" novalidate>
        @csrf

        <div class="form-group">
            <label for="login">Email / No. WhatsApp</label>
            <input type="text" id="login" name="login" value="{{ old('login') }}"
                   class="input @error('login') is-invalid @enderror"
                   placeholder="Contoh: user@gmail.com / 0812345678" required autofocus>
            @error('login') <p class="error-text">{{ $message }}</p> @enderror
        </div>

        @include('auth.partials.password')

        <label class="remember">
            <input type="checkbox" name="remember" value="1"> Ingat Saya
        </label>

        <button type="submit" class="btn-primary">LOGIN</button>
    </form>

    <div class="auth-footer">
        Belum memiliki akun? <a href="{{ route('register') }}">Daftar Akun Baru</a>
    </div>
@endsection